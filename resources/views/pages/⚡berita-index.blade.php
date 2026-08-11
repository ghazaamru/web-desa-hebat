<?php

use App\Models\News;
use App\Http\Controllers\HomeController;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Berita Desa')] #[Layout('layouts.public')] class extends Component {
    #[Computed]
    public function news(): \Illuminate\Contracts\Pagination\Paginator
    {
        return News::query()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->simplePaginate(9);
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 py-8 w-full space-y-8">
    <!-- Header -->
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Kabar Desa</span>
        <h1 class="text-3xl md:text-5xl font-black text-foreground-custom">Berita & Pengumuman</h1>
        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Ikuti perkembangan terbaru kegiatan pembangunan, pengumuman, dan acara sosial di Desa Dalangan.</p>
    </div>

    @if ($this->news->isEmpty())
        <div class="text-center py-16 bg-white border border-border-custom rounded-2xl shadow-sm">
            <flux:heading size="lg">Belum Ada Berita</flux:heading>
            <flux:text class="mt-1">Belum ada berita yang dipublikasikan.</flux:text>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($this->news as $item)
                <div wire:key="news-{{ $item->id }}" class="bg-background-custom border border-border-custom rounded-2xl overflow-hidden shadow-sm flex flex-col h-full">
                    <a href="{{ route('berita.show', $item->slug) }}" class="block aspect-video w-full overflow-hidden">
                        @if ($item->image)
                            <img src="{{ HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center hover:scale-105 transition duration-300">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Berita Desa</span>
                            </div>
                        @endif
                    </a>
                    <div class="p-5 flex flex-col gap-2.5 grow">
                        <span class="text-[10px] font-bold text-foreground-custom/40">{{ strtoupper($item->published_at->translatedFormat('d F Y')) }}</span>
                        <h3 class="font-bold text-sm hover:text-primary transition">
                            <a href="{{ route('berita.show', $item->slug) }}" wire:navigate>
                                {{ $item->title }}
                            </a>
                        </h3>
                        <p class="text-[11px] text-foreground-custom/75 leading-relaxed">{{ $item->excerpt }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $this->news->links() }}
        </div>
    @endif
</div>
