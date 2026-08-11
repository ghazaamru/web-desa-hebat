<?php

use App\Models\News;
use App\Http\Controllers\HomeController;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Berita Desa')] #[Layout('layouts.public')] class extends Component {
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $news = $this->news;
        if (! $news || is_null($news->published_at)) {
            abort(404);
        }
    }

    #[Computed]
    public function news(): ?News
    {
        return News::where('slug', $this->slug)->first();
    }
}; ?>

<div class="max-w-3xl mx-auto px-4 py-8 space-y-6 w-full">
    <!-- Back link -->
    <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-sm text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors" wire:navigate>
        &larr; Kembali ke Beranda
    </a>

    <!-- News details -->
    <div class="space-y-4">
        <flux:heading size="xl" class="leading-tight">{{ $this->news->title }}</flux:heading>

        <div class="flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400">
            <span>{{ $this->news->published_at->translatedFormat('d F Y H:i') }} WIB</span>
            <span>•</span>
            <span>Pemerintah Desa Dalangan</span>
        </div>
    </div>

    <!-- Featured Image -->
    @if ($this->news->image)
        <div class="aspect-video w-full rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800">
            <img src="{{ HomeController::getDirectImageUrl($this->news->image) }}" alt="{{ $this->news->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Excerpt -->
    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 border-l-4 border-zinc-900 dark:border-zinc-100 rounded-r-xl">
        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $this->news->excerpt }}</p>
    </div>

    <!-- Content -->
    <div class="prose dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300 leading-relaxed text-sm md:text-base space-y-4 whitespace-pre-line">
        {!! e($this->news->content) !!}
    </div>
</div>
