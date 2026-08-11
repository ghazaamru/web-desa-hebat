<?php

use App\Models\News;
use App\Models\VillageStatistic;
use App\Models\ApbdesItem;
use App\Models\Apparatus;
use App\Models\Gallery;
use App\Models\Potency;
use App\Enums\ApbdesCategory;
use App\Enums\PotencyCategory;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Authorize;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Kelola Konten Desa')] #[Layout('layouts.app')] class extends Component {
    use WithFileUploads;

    // Form fields for News
    public string $newsTitle = '';
    public string $newsExcerpt = '';
    public string $newsContent = '';
    public string $newsImage = '';
    public $newsImageUpload;
    public bool $newsIsPublished = true;
    public ?int $editingNewsId = null;

    // Form fields for VillageStatistic
    public string $statLabel = '';
    public string $statValue = '';
    public $heroImageUpload;
    public ?int $editingStatId = null;

    // Form fields for ApbdesItem
    public string $apbdesName = '';
    public string $apbdesAmount = '';
    public string $apbdesCategory = 'pendapatan';
    public ?int $editingApbdesId = null;

    // Form fields for Apparatus
    public string $appName = '';
    public string $appPosition = '';
    public string $appImage = '';
    public $appImageUpload;
    public string $appWelcomeMessage = '';
    public ?int $editingAppId = null;

    // Form fields for Gallery
    public string $galTitle = '';
    public string $galDescription = '';
    public string $galImage = '';
    public $galImageUpload;
    public ?int $editingGalId = null;

    // Form fields for Potency
    public string $potTitle = '';
    public string $potCategory = 'umkm';
    public string $potDescription = '';
    public string $potLatitude = '-7.250445';
    public string $potLongitude = '112.768845';
    public string $potWhatsapp = '';
    public string $potImage = '';
    public $potImageUpload;
    public ?int $editingPotId = null;

    // Form fields for Complaint
    public string $compName = '';
    public string $compPhone = '';
    public string $compEmail = '';
    public string $compSubject = '';
    public string $compContent = '';
    public string $compStatus = 'pending';
    public ?int $viewingComplaintId = null;

    // Computed properties for lists
    #[Computed]
    public function newsList() { return News::latest()->get(); }

    #[Computed]
    public function statsList() { return VillageStatistic::orderBy('sort_order')->get(); }

    #[Computed]
    public function apbdesList() { return ApbdesItem::all(); }

    #[Computed]
    public function apparatusList() { return Apparatus::orderBy('sort_order')->get(); }

    #[Computed]
    public function galleryList() { return Gallery::latest()->get(); }

    #[Computed]
    public function potencyList() { return Potency::latest()->get(); }

    #[Computed]
    public function complaintList() { return \App\Models\Complaint::latest()->get(); }

    #[Computed]
    public function totalHits() { return \App\Models\PageView::count(); }

    #[Computed]
    public function uniqueVisitors() { return \App\Models\Visitor::count(); }

    #[Computed]
    public function popularPages()
    {
        return \App\Models\PageView::select('path', DB::raw('count(*) as hits'))
            ->groupBy('path')
            ->orderByDesc('hits')
            ->get();
    }

    #[Computed]
    public function chartData()
    {
        $days = collect();
        $visitors = collect();
        $pageViews = collect();

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $days->push(now()->subDays($i)->translatedFormat('d M'));

            $visitors->push(\App\Models\Visitor::where('visit_date', $date)->count());
            $pageViews->push(\App\Models\PageView::whereDate('created_at', $date)->count());
        }

        return [
            'labels' => $days->toArray(),
            'visitors' => $visitors->toArray(),
            'pageViews' => $pageViews->toArray(),
        ];
    }

    // News Actions
    #[Authorize('manage-content')]
    public function editNews($id): void
    {
        $news = News::findOrFail($id);
        $this->editingNewsId = $news->id;
        $this->newsTitle = $news->title;
        $this->newsExcerpt = $news->excerpt;
        $this->newsContent = $news->content;
        $this->newsImage = $news->image ?? '';
        $this->newsIsPublished = !is_null($news->published_at);
        $this->dispatch('open-modal', name: 'news-modal');
    }

    #[Authorize('manage-content')]
    public function saveNews(): void
    {
        $this->validate([
            'newsTitle' => 'required|string|max:255',
            'newsExcerpt' => 'required|string',
            'newsContent' => 'required|string',
        ]);

        $imagePath = $this->newsImage;
        if ($this->newsImageUpload) {
            $this->validate(['newsImageUpload' => 'image|max:2048']);
            $imagePath = $this->newsImageUpload->store('news', 'public');
        }

        News::updateOrCreate(
            ['id' => $this->editingNewsId],
            [
                'title' => $this->newsTitle,
                'slug' => Str::slug($this->newsTitle),
                'excerpt' => $this->newsExcerpt,
                'content' => $this->newsContent,
                'image' => $imagePath ?: 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&q=80&w=600',
                'published_at' => $this->newsIsPublished ? now() : null,
            ]
        );

        $this->resetNewsForm();
        $this->dispatch('close-modal', name: 'news-modal');
        Flux::toast(variant: 'success', text: 'Berita berhasil disimpan.');
    }

    #[Authorize('manage-content')]
    public function deleteNews($id): void
    {
        News::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Berita berhasil dihapus.');
    }

    public function resetNewsForm(): void
    {
        $this->reset(['newsTitle', 'newsExcerpt', 'newsContent', 'newsImage', 'newsImageUpload', 'newsIsPublished', 'editingNewsId']);
    }

    // Statistic Actions
    #[Authorize('manage-content')]
    public function editStat($id): void
    {
        $stat = VillageStatistic::findOrFail($id);
        $this->editingStatId = $stat->id;
        $this->statLabel = $stat->label;
        $this->statValue = $stat->value;
        $this->dispatch('open-modal', name: 'stat-modal');
    }

    #[Authorize('manage-content')]
    public function saveStat(): void
    {
        $this->validate([
            'statLabel' => 'required|string|max:255',
            'statValue' => 'required_without:heroImageUpload',
        ]);

        $statValue = $this->statValue;
        if ($this->statLabel === 'Hero Image' && $this->heroImageUpload) {
            $this->validate(['heroImageUpload' => 'image|max:2048']);
            $statValue = $this->heroImageUpload->store('hero', 'public');
        }

        VillageStatistic::updateOrCreate(
            ['id' => $this->editingStatId],
            [
                'label' => $this->statLabel,
                'value' => $statValue,
            ]
        );

        $this->reset(['statLabel', 'statValue', 'heroImageUpload', 'editingStatId']);
        $this->dispatch('close-modal', name: 'stat-modal');
        Flux::toast(variant: 'success', text: 'Statistik berhasil disimpan.');
    }

    // APBDes Actions
    #[Authorize('manage-content')]
    public function editApbdes($id): void
    {
        $item = ApbdesItem::findOrFail($id);
        $this->editingApbdesId = $item->id;
        $this->apbdesName = $item->name;
        $this->apbdesAmount = (string)$item->amount;
        $this->apbdesCategory = $item->category->value;
        $this->dispatch('open-modal', name: 'apbdes-modal');
    }

    #[Authorize('manage-content')]
    public function saveApbdes(): void
    {
        $this->validate([
            'apbdesName' => 'required|string|max:255',
            'apbdesAmount' => 'required|numeric|min:0',
            'apbdesCategory' => 'required|in:pendapatan,belanja',
        ]);

        ApbdesItem::updateOrCreate(
            ['id' => $this->editingApbdesId],
            [
                'name' => $this->apbdesName,
                'amount' => $this->apbdesAmount,
                'category' => ApbdesCategory::from($this->apbdesCategory),
            ]
        );

        $this->resetApbdesForm();
        $this->dispatch('close-modal', name: 'apbdes-modal');
        Flux::toast(variant: 'success', text: 'Item APBDes berhasil disimpan.');
    }

    #[Authorize('manage-content')]
    public function deleteApbdes($id): void
    {
        ApbdesItem::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Item APBDes berhasil dihapus.');
    }

    public function resetApbdesForm(): void
    {
        $this->reset(['apbdesName', 'apbdesAmount', 'apbdesCategory', 'editingApbdesId']);
    }

    // Apparatus Actions
    #[Authorize('manage-content')]
    public function editApp($id): void
    {
        $app = Apparatus::findOrFail($id);
        $this->editingAppId = $app->id;
        $this->appName = $app->name;
        $this->appPosition = $app->position;
        $this->appWelcomeMessage = $app->welcome_message ?? '';
        $this->appImage = $app->image ?? '';
        $this->dispatch('open-modal', name: 'app-modal');
    }

    #[Authorize('manage-content')]
    public function saveApp(): void
    {
        $this->validate([
            'appName' => 'required|string|max:255',
            'appPosition' => 'required|string|max:255',
            'appWelcomeMessage' => 'nullable|string',
        ]);

        $imagePath = $this->appImage;
        if ($this->appImageUpload) {
            $this->validate(['appImageUpload' => 'image|max:2048']);
            $imagePath = $this->appImageUpload->store('apparatus', 'public');
        }

        Apparatus::updateOrCreate(
            ['id' => $this->editingAppId],
            [
                'name' => $this->appName,
                'position' => $this->appPosition,
                'welcome_message' => $this->appWelcomeMessage ?: null,
                'image' => $imagePath ?: null,
            ]
        );

        $this->resetAppForm();
        $this->dispatch('close-modal', name: 'app-modal');
        Flux::toast(variant: 'success', text: 'Perangkat desa berhasil disimpan.');
    }

    #[Authorize('manage-content')]
    public function deleteApp($id): void
    {
        Apparatus::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Perangkat desa berhasil dihapus.');
    }

    public function resetAppForm(): void
    {
        $this->reset(['appName', 'appPosition', 'appImage', 'appImageUpload', 'appWelcomeMessage', 'editingAppId']);
    }

    // Gallery Actions
    #[Authorize('manage-content')]
    public function editGal($id): void
    {
        $gal = Gallery::findOrFail($id);
        $this->editingGalId = $gal->id;
        $this->galTitle = $gal->title;
        $this->galDescription = $gal->description ?? '';
        $this->galImage = $gal->image;
        $this->dispatch('open-modal', name: 'gallery-modal');
    }

    #[Authorize('manage-content')]
    public function saveGal(): void
    {
        $this->validate([
            'galTitle' => 'required|string|max:255',
            'galDescription' => 'nullable|string',
        ]);

        $imagePath = $this->galImage;
        if ($this->galImageUpload) {
            $this->validate(['galImageUpload' => 'image|max:2048']);
            $imagePath = $this->galImageUpload->store('gallery', 'public');
        } elseif (! $this->editingGalId) {
            $this->validate(['galImageUpload' => 'required|image|max:2048']);
            $imagePath = $this->galImageUpload->store('gallery', 'public');
        }

        Gallery::updateOrCreate(
            ['id' => $this->editingGalId],
            [
                'title' => $this->galTitle,
                'description' => $this->galDescription ?: null,
                'image' => $imagePath,
            ]
        );

        $this->resetGalForm();
        $this->dispatch('close-modal', name: 'gallery-modal');
        Flux::toast(variant: 'success', text: 'Galeri berhasil disimpan.');
    }

    #[Authorize('manage-content')]
    public function deleteGal($id): void
    {
        Gallery::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Galeri berhasil dihapus.');
    }

    public function resetGalForm(): void
    {
        $this->reset(['galTitle', 'galDescription', 'galImage', 'galImageUpload', 'editingGalId']);
    }

    // Potency Actions
    #[Authorize('manage-content')]
    public function editPot($id): void
    {
        $pot = Potency::findOrFail($id);
        $this->editingPotId = $pot->id;
        $this->potTitle = $pot->title;
        $this->potCategory = $pot->category->value;
        $this->potDescription = $pot->description;
        $this->potLatitude = (string)$pot->latitude;
        $this->potLongitude = (string)$pot->longitude;
        $this->potWhatsapp = $pot->whatsapp ?? '';
        $this->potImage = $pot->image ?? '';
        $this->dispatch('open-modal', name: 'potency-modal');
    }

    #[Authorize('manage-content')]
    public function savePot(): void
    {
        $this->validate([
            'potTitle' => 'required|string|max:255',
            'potCategory' => 'required|in:bumdes,umkm,wisata,fasilitas',
            'potDescription' => 'required|string',
            'potLatitude' => 'required|numeric',
            'potLongitude' => 'required|numeric',
            'potWhatsapp' => 'nullable|string',
        ]);

        $imagePath = $this->potImage;
        if ($this->potImageUpload) {
            $this->validate(['potImageUpload' => 'image|max:2048']);
            $imagePath = $this->potImageUpload->store('potency', 'public');
        }

        Potency::updateOrCreate(
            ['id' => $this->editingPotId],
            [
                'title' => $this->potTitle,
                'category' => PotencyCategory::from($this->potCategory),
                'description' => $this->potDescription,
                'latitude' => $this->potLatitude,
                'longitude' => $this->potLongitude,
                'whatsapp' => $this->potWhatsapp ?: null,
                'image' => $imagePath ?: null,
            ]
        );

        $this->resetPotForm();
        $this->dispatch('close-modal', name: 'potency-modal');
        Flux::toast(variant: 'success', text: 'Potensi berhasil disimpan.');
    }

    #[Authorize('manage-content')]
    public function deletePot($id): void
    {
        Potency::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Potensi berhasil dihapus.');
    }

    public function resetPotForm(): void
    {
        $this->reset(['potTitle', 'potCategory', 'potDescription', 'potLatitude', 'potLongitude', 'potWhatsapp', 'potImage', 'potImageUpload', 'editingPotId']);
    }

    // Complaint Actions
    #[Authorize('manage-content')]
    public function viewComplaint($id): void
    {
        $comp = \App\Models\Complaint::findOrFail($id);
        $this->viewingComplaintId = $comp->id;
        $this->compName = $comp->name;
        $this->compPhone = $comp->phone;
        $this->compEmail = $comp->email ?? '';
        $this->compSubject = $comp->subject;
        $this->compContent = $comp->content;
        $this->compStatus = $comp->status;
        $this->dispatch('open-modal', name: 'complaint-modal');
    }

    #[Authorize('manage-content')]
    public function updateComplaintStatus(): void
    {
        $this->validate([
            'compStatus' => 'required|in:pending,processed,resolved',
        ]);

        $comp = \App\Models\Complaint::findOrFail($this->viewingComplaintId);
        $comp->update(['status' => $this->compStatus]);

        $this->dispatch('close-modal', name: 'complaint-modal');
        Flux::toast(variant: 'success', text: 'Status aduan berhasil diperbarui.');
    }

    #[Authorize('manage-content')]
    public function deleteComplaint($id): void
    {
        \App\Models\Complaint::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Aduan berhasil dihapus.');
    }
};
?>

<div x-data="{ activeTab: 'berita' }" x-on:open-modal.window="$dispatch('modal-show', { name: $event.detail.name })" x-on:close-modal.window="$dispatch('modal-close', { name: $event.detail.name })" class="space-y-6">
    <div>
        <flux:heading size="xl">Kelola Konten Desa</flux:heading>
        <flux:text>Kelola data-data dinamis yang tampil di halaman depan website resmi Desa Dalangan.</flux:text>
    </div>

    <!-- TABS NAVIGATION -->
    <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-px flex-wrap">
        <button x-on:click="activeTab = 'berita'" :class="activeTab === 'berita' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Berita</button>
        <button x-on:click="activeTab = 'statistik'" :class="activeTab === 'statistik' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Statistik & Profil</button>
        <button x-on:click="activeTab = 'apbdes'" :class="activeTab === 'apbdes' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">APBDes</button>
        <button x-on:click="activeTab = 'aparat'" :class="activeTab === 'aparat' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Perangkat Desa</button>
        <button x-on:click="activeTab = 'galeri'" :class="activeTab === 'galeri' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Galeri</button>
        <button x-on:click="activeTab = 'potensi'" :class="activeTab === 'potensi' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Potensi & UMKM</button>
        <button x-on:click="activeTab = 'aduan'" :class="activeTab === 'aduan' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Aduan Warga</button>
        <button x-on:click="activeTab = 'analitik'" :class="activeTab === 'analitik' ? 'border-zinc-900 dark:border-white text-zinc-900 dark:text-white border-b-2 font-bold' : 'text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300'" class="px-4 py-2.5 text-sm transition cursor-pointer">Analitik Kunjungan</button>
    </div>

    <!-- TABS PANELS -->
    <div>
        <!-- BERITA PANEL -->
        <div x-show="activeTab === 'berita'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Daftar Berita Desa</flux:heading>
                <flux:button wire:click="resetNewsForm" x-on:click="$dispatch('modal-show', { name: 'news-modal' })" variant="primary" size="sm" icon="plus">Tambah Berita</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Judul</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Tanggal Rilis</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->newsList as $item)
                        <flux:table.row :key="'news-'.$item->id">
                            <flux:table.cell class="font-semibold">{{ $item->title }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ $item->published_at ? 'green' : 'zinc' }}">
                                    {{ $item->published_at ? 'Published' : 'Draft' }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>{{ $item->published_at?->translatedFormat('d M Y H:i') ?? '-' }}</flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="editNews({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                                <flux:button wire:click="deleteNews({{ $item->id }})" wire:confirm="Hapus berita ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- STATISTIK PANEL -->
        <div x-show="activeTab === 'statistik'" class="space-y-4">
            <div>
                <flux:heading size="lg">Statistik Kependudukan & Profil Desa</flux:heading>
                <flux:text>Nilai statistik kependudukan dan teks profil (Visi, Misi, Sejarah) yang ditampilkan di website.</flux:text>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Label</flux:table.column>
                    <flux:table.column>Nilai</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->statsList as $item)
                        <flux:table.row :key="'stat-'.$item->id">
                            <flux:table.cell class="font-semibold">{{ $item->label }}</flux:table.cell>
                            <flux:table.cell>{{ $item->value }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:button wire:click="editStat({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- APBDES PANEL -->
        <div x-show="activeTab === 'apbdes'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">APBDes (Anggaran Pembangunan)</flux:heading>
                <flux:button wire:click="resetApbdesForm" x-on:click="$dispatch('modal-show', { name: 'apbdes-modal' })" variant="primary" size="sm" icon="plus">Tambah Anggaran</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Kategori</flux:table.column>
                    <flux:table.column>Nama Anggaran</flux:table.column>
                    <flux:table.column>Jumlah</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->apbdesList as $item)
                        <flux:table.row :key="'apbdes-'.$item->id">
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ $item->category->value === 'pendapatan' ? 'blue' : 'emerald' }}">
                                    {{ $item->category->label() }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="font-semibold">{{ $item->name }}</flux:table.cell>
                            <flux:table.cell>Rp {{ number_format($item->amount, 0, ',', '.') }}</flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="editApbdes({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                                <flux:button wire:click="deleteApbdes({{ $item->id }})" wire:confirm="Hapus anggaran ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- PERANGKAT DESA PANEL -->
        <div x-show="activeTab === 'aparat'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Aparat Desa (SOTK & Sambutan)</flux:heading>
                <flux:button wire:click="resetAppForm" x-on:click="$dispatch('modal-show', { name: 'app-modal' })" variant="primary" size="sm" icon="plus">Tambah Perangkat</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Nama</flux:table.column>
                    <flux:table.column>Jabatan</flux:table.column>
                    <flux:table.column>Sambutan Kades</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->apparatusList as $item)
                        <flux:table.row :key="'app-'.$item->id">
                            <flux:table.cell class="font-semibold">{{ $item->name }}</flux:table.cell>
                            <flux:table.cell>{{ $item->position }}</flux:table.cell>
                            <flux:table.cell>
                                @if ($item->welcome_message)
                                    <span class="text-xs text-zinc-500 italic block max-w-xs truncate">{{ $item->welcome_message }}</span>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="editApp({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                                <flux:button wire:click="deleteApp({{ $item->id }})" wire:confirm="Hapus perangkat ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- GALERI PANEL -->
        <div x-show="activeTab === 'galeri'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Galeri Kegiatan</flux:heading>
                <flux:button wire:click="resetGalForm" x-on:click="$dispatch('modal-show', { name: 'gallery-modal' })" variant="primary" size="sm" icon="plus">Tambah Foto</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Preview</flux:table.column>
                    <flux:table.column>Judul</flux:table.column>
                    <flux:table.column>Keterangan</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->galleryList as $item)
                        <flux:table.row :key="'gal-'.$item->id">
                            <flux:table.cell>
                                <img src="{{ $item->image }}" class="w-12 h-12 object-cover rounded-lg border">
                            </flux:table.cell>
                            <flux:table.cell class="font-semibold">{{ $item->title }}</flux:table.cell>
                            <flux:table.cell>{{ Str::limit($item->description, 50) }}</flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="editGal({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                                <flux:button wire:click="deleteGal({{ $item->id }})" wire:confirm="Hapus galeri ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- POTENSI & UMKM PANEL -->
        <div x-show="activeTab === 'potensi'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Potensi Desa, BUMDes & UMKM</flux:heading>
                <flux:button wire:click="resetPotForm" x-on:click="$dispatch('modal-show', { name: 'potency-modal' })" variant="primary" size="sm" icon="plus">Tambah Potensi</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Kategori</flux:table.column>
                    <flux:table.column>Nama Usaha/Potensi</flux:table.column>
                    <flux:table.column>Deskripsi</flux:table.column>
                    <flux:table.column>Koordinat</flux:table.column>
                    <flux:table.column>WhatsApp</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->potencyList as $item)
                        <flux:table.row :key="'pot-'.$item->id">
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ match($item->category->value) {
                                    'bumdes' => 'blue',
                                    'umkm' => 'green',
                                    'wisata' => 'amber',
                                    'fasilitas' => 'violet',
                                } }}">
                                    {{ $item->category->label() }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="font-semibold">{{ $item->title }}</flux:table.cell>
                            <flux:table.cell>{{ Str::limit($item->description, 50) }}</flux:table.cell>
                            <flux:table.cell class="text-xs text-zinc-500">{{ $item->latitude }}, {{ $item->longitude }}</flux:table.cell>
                            <flux:table.cell>{{ $item->whatsapp ?? '-' }}</flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="editPot({{ $item->id }})" variant="ghost" size="sm" icon="pencil"></flux:button>
                                <flux:button wire:click="deletePot({{ $item->id }})" wire:confirm="Hapus potensi ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- ADUAN WARGA PANEL -->
        <div x-show="activeTab === 'aduan'" class="space-y-4">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Daftar Pengaduan Warga</flux:heading>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Tanggal</flux:table.column>
                    <flux:table.column>Nama Warga</flux:table.column>
                    <flux:table.column>Subjek</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Aksi</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->complaintList as $item)
                        <flux:table.row :key="'comp-'.$item->id">
                            <flux:table.cell>{{ $item->created_at->translatedFormat('d M Y H:i') }}</flux:table.cell>
                            <flux:table.cell class="font-semibold">{{ $item->name }}</flux:table.cell>
                            <flux:table.cell>{{ $item->subject }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ $item->status === 'pending' ? 'yellow' : ($item->status === 'processed' ? 'blue' : 'green') }}">
                                    {{ ucfirst($item->status) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="flex gap-2">
                                <flux:button wire:click="viewComplaint({{ $item->id }})" variant="ghost" size="sm" icon="eye"></flux:button>
                                <flux:button wire:click="deleteComplaint({{ $item->id }})" wire:confirm="Hapus aduan ini?" variant="ghost" size="sm" icon="trash" class="text-red-500"></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- ANALITIK PANEL -->
        <div x-show="activeTab === 'analitik'">
            <div
                x-data="{
                    chart: null,
                    labels: @js($this->chartData['labels']),
                    visitors: @js($this->chartData['visitors']),
                    pageViews: @js($this->chartData['pageViews']),
                    initChart() {
                        if (this.chart) this.chart.destroy();
                        this.chart = new Chart(this.$refs.canvas, {
                            type: 'line',
                            data: {
                                labels: this.labels,
                                datasets: [
                                    {
                                        label: 'Pengunjung Unik',
                                        data: this.visitors,
                                        borderColor: '#0284c7',
                                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                                        tension: 0.3,
                                        fill: true
                                    },
                                    {
                                        label: 'Total Klik Halaman',
                                        data: this.pageViews,
                                        borderColor: '#059669',
                                        backgroundColor: 'rgba(5, 150, 105, 0.1)',
                                        tension: 0.3,
                                        fill: true
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                                }
                            }
                        });
                    }
                }"
                x-init="
                    if (window.Chart) {
                        initChart();
                    } else {
                        let script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                        script.onload = () => { initChart(); };
                        document.head.appendChild(script);
                    }
                    $watch('activeTab', value => {
                        if (value === 'analitik') {
                            $nextTick(() => { initChart(); });
                        }
                    });
                "
                class="space-y-6"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                        <span class="text-sm font-semibold text-zinc-500">Total Klik Halaman (Hits)</span>
                        <span class="text-3xl font-black text-foreground-custom">{{ number_format($this->totalHits, 0, ',', '.') }}</span>
                    </div>
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                        <span class="text-sm font-semibold text-zinc-500">Total Pengunjung Unik</span>
                        <span class="text-3xl font-black text-foreground-custom">{{ number_format($this->uniqueVisitors, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm space-y-4">
                    <flux:heading size="lg">Tren Kunjungan (30 Hari Terakhir)</flux:heading>
                    <div class="h-80 relative">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl shadow-sm space-y-4">
                    <flux:heading size="lg">Halaman Terpopuler</flux:heading>
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Rute/Path</flux:table.column>
                            <flux:table.column>Total Klik (Hits)</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach ($this->popularPages as $item)
                                <flux:table.row :key="'page-'.$item->path">
                                    <flux:table.cell class="font-mono text-xs">{{ $item->path }}</flux:table.cell>
                                    <flux:table.cell class="font-bold">{{ number_format($item->hits, 0, ',', '.') }}</flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL NEWS -->
    <flux:modal name="news-modal" class="max-w-xl">
        <form wire:submit="saveNews" class="space-y-4">
            <flux:heading size="lg">{{ $editingNewsId ? 'Edit Berita' : 'Tambah Berita' }}</flux:heading>
            <flux:input label="Judul Berita" wire:model="newsTitle" required />
            <flux:textarea label="Ringkasan" wire:model="newsExcerpt" required />
            <flux:textarea label="Isi Berita" wire:model="newsContent" rows="6" required />
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">File Gambar</label>
                <flux:input type="file" wire:model="newsImageUpload" />
                @if ($newsImageUpload)
                    <img src="{{ $newsImageUpload->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @elseif ($newsImage)
                    <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($newsImage) }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @endif
            </div>
            <flux:checkbox label="Terbitkan Sekarang" wire:model="newsIsPublished" />
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL STATISTIK -->
    <flux:modal name="stat-modal" class="max-w-xl">
        <form wire:submit="saveStat" class="space-y-4">
            <flux:heading size="lg">Edit Data</flux:heading>
            <flux:input label="Label" wire:model="statLabel" required disabled />
            @if ($statLabel === 'Hero Image')
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Upload Gambar Hero</label>
                    <flux:input type="file" wire:model="heroImageUpload" />
                    @if ($heroImageUpload)
                        <img src="{{ $heroImageUpload->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                    @elseif ($statValue)
                        <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($statValue) }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                    @endif
                </div>
            @elseif (in_array($statLabel, ['Visi', 'Misi', 'Sejarah']))
                <flux:textarea label="Isi Konten" wire:model="statValue" rows="8" required />
            @else
                <flux:input label="Nilai" wire:model="statValue" required />
            @endif
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL APBDES -->
    <flux:modal name="apbdes-modal" class="max-w-md">
        <form wire:submit="saveApbdes" class="space-y-4">
            <flux:heading size="lg">{{ $editingApbdesId ? 'Edit Anggaran' : 'Tambah Anggaran' }}</flux:heading>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kategori</label>
                <select wire:model="apbdesCategory" class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm w-full text-zinc-700 dark:text-zinc-300">
                    <option value="pendapatan">Pendapatan</option>
                    <option value="belanja">Belanja</option>
                </select>
            </div>
            <flux:input label="Nama Anggaran" wire:model="apbdesName" required />
            <flux:input label="Jumlah (Rp)" type="number" wire:model="apbdesAmount" required />
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL PERANGKAT -->
    <flux:modal name="app-modal" class="max-w-xl">
        <form wire:submit="saveApp" class="space-y-4">
            <flux:heading size="lg">{{ $editingAppId ? 'Edit Perangkat' : 'Tambah Perangkat' }}</flux:heading>
            <flux:input label="Nama Lengkap" wire:model="appName" required />
            <flux:input label="Jabatan" wire:model="appPosition" required />
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Foto Perangkat (Opsional)</label>
                <flux:input type="file" wire:model="appImageUpload" />
                @if ($appImageUpload)
                    <img src="{{ $appImageUpload->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @elseif ($appImage)
                    <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($appImage) }}" class="w-20 h-20 object-cover rounded-full border mt-2">
                @endif
            </div>
            @if ($appPosition === 'Kepala Desa')
                <flux:textarea label="Sambutan Kepala Desa" wire:model="appWelcomeMessage" rows="4" placeholder="Tulis pesan sambutan..." />
            @endif
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL GALERI -->
    <flux:modal name="gallery-modal" class="max-w-md">
        <form wire:submit="saveGal" class="space-y-4">
            <flux:heading size="lg">{{ $editingGalId ? 'Edit Galeri' : 'Tambah Galeri' }}</flux:heading>
            <flux:input label="Judul Foto" wire:model="galTitle" required />
            <flux:textarea label="Keterangan (Opsional)" wire:model="galDescription" />
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">File Gambar</label>
                <flux:input type="file" wire:model="galImageUpload" />
                @if ($galImageUpload)
                    <img src="{{ $galImageUpload->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @elseif ($galImage)
                    <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($galImage) }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @endif
            </div>
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL POTENSI -->
    <flux:modal name="potency-modal" class="max-w-xl">
        <form wire:submit="savePot" class="space-y-4">
            <flux:heading size="lg">{{ $editingPotId ? 'Edit Potensi' : 'Tambah Potensi' }}</flux:heading>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kategori</label>
                <select wire:model="potCategory" class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm w-full text-zinc-700 dark:text-zinc-300">
                    <option value="bumdes">BUMDes</option>
                    <option value="umkm">UMKM / Usaha Daerah</option>
                    <option value="wisata">Wisata</option>
                    <option value="fasilitas">Fasilitas Umum</option>
                </select>
            </div>
            <flux:input label="Nama Usaha / Destinasi" wire:model="potTitle" required />
            <flux:textarea label="Deskripsi" wire:model="potDescription" rows="3" required />
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="Latitude" wire:model="potLatitude" required />
                <flux:input label="Longitude" wire:model="potLongitude" required />
            </div>
            <flux:input label="WhatsApp (cth: 6281234567890)" wire:model="potWhatsapp" />
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Gambar Potensi (Opsional)</label>
                <flux:input type="file" wire:model="potImageUpload" />
                @if ($potImageUpload)
                    <img src="{{ $potImageUpload->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @elseif ($potImage)
                    <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($potImage) }}" class="w-32 h-20 object-cover rounded-lg border mt-2">
                @endif
            </div>
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Batal</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- MODAL DETAIL COMPLAINT -->
    <flux:modal name="complaint-modal" class="max-w-xl">
        <form wire:submit="updateComplaintStatus" class="space-y-4">
            <flux:heading size="lg">Detail Pengaduan Warga</flux:heading>
            <div class="space-y-3 text-sm text-zinc-700 dark:text-zinc-300">
                <div>
                    <strong class="block text-xs font-bold text-zinc-500 uppercase tracking-wider">Nama Pengadu</strong>
                    <div class="mt-0.5">{{ $compName }}</div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong class="block text-xs font-bold text-zinc-500 uppercase tracking-wider">WhatsApp</strong>
                        <div class="mt-0.5">{{ $compPhone }}</div>
                    </div>
                    <div>
                        <strong class="block text-xs font-bold text-zinc-500 uppercase tracking-wider">Email</strong>
                        <div class="mt-0.5">{{ $compEmail ?: '-' }}</div>
                    </div>
                </div>
                <div>
                    <strong class="block text-xs font-bold text-zinc-500 uppercase tracking-wider">Subjek</strong>
                    <div class="mt-0.5">{{ $compSubject }}</div>
                </div>
                <div>
                    <strong class="block text-xs font-bold text-zinc-500 uppercase tracking-wider">Isi Laporan</strong>
                    <div class="p-3 mt-1 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 whitespace-pre-line leading-relaxed">{{ $compContent }}</div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status Laporan</label>
                    <select wire:model="compStatus" class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm w-full text-zinc-700 dark:text-zinc-300">
                        <option value="pending">Pending (Menunggu)</option>
                        <option value="processed">Processed (Sedang Diproses)</option>
                        <option value="resolved">Resolved (Selesai)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-2">
                <flux:modal.close><flux:button variant="filled">Tutup</flux:button></flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan Perubahan</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
