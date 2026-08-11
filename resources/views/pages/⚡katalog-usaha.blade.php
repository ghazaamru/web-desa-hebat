<?php

use App\Enums\PotencyCategory;
use App\Models\Potency;
use App\Http\Controllers\HomeController;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Katalog Usaha BUMDes & UMKM')] #[Layout('layouts.public')] class extends Component {
    #[Url]
    public string $search = '';

    #[Url]
    public string $category = '';

    /** @return \Illuminate\Database\Eloquent\Collection<int, Potency> */
    #[Computed]
    public function potencies(): \Illuminate\Database\Eloquent\Collection
    {
        return Potency::query()
            ->whereIn('category', [
                PotencyCategory::Bumdes,
                PotencyCategory::Umkm,
                PotencyCategory::Wisata,
            ])
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->latest()
            ->get();
    }

    public function setCategory(string $value): void
    {
        $this->category = $this->category === $value ? '' : $value;
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'category');
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 py-8 w-full space-y-8">
    <!-- Header -->
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Ekonomi Kreatif</span>
        <h1 class="text-3xl md:text-5xl font-black text-foreground-custom">Katalog Usaha BUMDes & UMKM</h1>
        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Daftar badan usaha milik desa dan produk kreatif buatan warga Desa Dalangan.</p>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="flex flex-col sm:flex-row gap-3 bg-white border border-border-custom p-4 rounded-2xl shadow-sm">
        <div class="flex-1">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama usaha atau deskripsi..."
                icon="magnifying-glass"
            />
        </div>

        <div class="flex flex-wrap gap-2 items-center">
            <button
                wire:click="setCategory('')"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer border {{ $category === '' ? 'bg-primary border-primary text-white' : 'bg-white border-border-custom text-foreground-custom/80 hover:bg-muted-custom' }}"
            >
                Semua
            </button>

            @foreach ([
                PotencyCategory::Bumdes,
                PotencyCategory::Umkm,
                PotencyCategory::Wisata,
            ] as $cat)
                <button
                    wire:click="setCategory('{{ $cat->value }}')"
                    class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer border {{ $category === $cat->value ? 'bg-primary border-primary text-white' : 'bg-white border-border-custom text-foreground-custom/80 hover:bg-muted-custom' }}"
                >
                    {{ $cat->label() }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Results Grid --}}
    @if ($this->potencies->isEmpty())
        <div class="text-center py-16 bg-white border border-border-custom rounded-2xl shadow-sm">
            <flux:icon.magnifying-glass class="mx-auto h-10 w-10 text-zinc-400" />
            <flux:heading size="lg" class="mt-4">Tidak Ada Hasil</flux:heading>
            <flux:text class="mt-1">Coba ubah filter atau kata kunci pencarian Anda.</flux:text>
            <flux:button wire:click="resetFilters" variant="primary" size="sm" class="mt-4">Reset Filter</flux:button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($this->potencies as $item)
                <div wire:key="potency-{{ $item->id }}" class="bg-white border border-border-custom rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    {{-- Image --}}
                    <div class="aspect-video bg-slate-100 relative overflow-hidden">
                        @if ($item->image)
                            <img src="{{ HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                </svg>
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 px-2 py-1 text-[10px] font-bold rounded-md text-white
                            {{ match($item->category) {
                                PotencyCategory::Bumdes => 'bg-primary',
                                PotencyCategory::Umkm => 'bg-accent-green',
                                PotencyCategory::Wisata => 'bg-amber-600',
                            } }}">
                            {{ $item->category->label() }}
                        </span>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col gap-3 grow">
                        <h3 class="font-bold text-sm text-foreground-custom">{{ $item->title }}</h3>
                        <p class="text-xs text-foreground-custom/75 leading-relaxed line-clamp-3">{{ $item->description }}</p>

                        @if ($item->whatsapp)
                            <div class="mt-auto pt-2">
                                <a
                                    href="https://wa.me/{{ $item->whatsapp }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="px-4 py-2 bg-accent-green hover:bg-accent-green/90 text-white text-xs font-bold rounded-xl transition shadow-sm inline-flex items-center justify-center gap-1.5 w-full"
                                >
                                    Hubungi Pengelola
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
