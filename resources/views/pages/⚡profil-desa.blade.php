<?php

use App\Models\VillageStatistic;
use App\Models\Apparatus;
use App\Http\Controllers\HomeController;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Profil Desa')] #[Layout('layouts.public')] class extends Component {
    #[Computed]
    public function visi(): string
    {
        return VillageStatistic::where('label', 'Visi')->value('value') ?? 'Visi desa belum diisi.';
    }

    #[Computed]
    public function misi(): string
    {
        return VillageStatistic::where('label', 'Misi')->value('value') ?? 'Misi desa belum diisi.';
    }

    #[Computed]
    public function sejarah(): string
    {
        return VillageStatistic::where('label', 'Sejarah')->value('value') ?? 'Sejarah desa belum diisi.';
    }

    #[Computed]
    public function apparatus()
    {
        return Apparatus::orderBy('sort_order')->get();
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 py-8 w-full space-y-12">
    <!-- Header -->
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Tentang Kami</span>
        <h1 class="text-3xl md:text-5xl font-black text-foreground-custom">Profil Desa Dalangan</h1>
        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Mengenal lebih dekat Visi, Misi, Sejarah, dan Struktur Tata Kerja Pemerintahan Desa Dalangan.</p>
    </div>

    <!-- Visi & Misi Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
        <!-- Visi Card -->
        <div class="p-6 bg-white border border-border-custom rounded-2xl space-y-4 shadow-sm flex flex-col justify-center">
            <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Visi Desa</span>
            <p class="text-lg md:text-2xl font-black text-primary leading-relaxed italic">"{{ $this->visi }}"</p>
        </div>

        <!-- Misi Card -->
        <div class="p-6 bg-white border border-border-custom rounded-2xl space-y-4 shadow-sm">
            <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Misi Desa</span>
            <div class="text-xs md:text-sm text-foreground-custom/70 leading-relaxed whitespace-pre-line space-y-2">
                {{ $this->misi }}
            </div>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section class="max-w-3xl mx-auto p-6 bg-white border border-border-custom rounded-2xl space-y-4 shadow-sm">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Sejarah Desa</span>
        <h2 class="text-xl md:text-2xl font-black text-foreground-custom">Asal Usul & Perkembangan Desa</h2>
        <div class="text-xs md:text-sm text-foreground-custom/70 leading-relaxed whitespace-pre-line space-y-4">
            {{ $this->sejarah }}
        </div>
    </section>

    <!-- SOTK / Apparatus Section -->
    <section class="max-w-5xl mx-auto space-y-6">
        <div class="text-center">
            <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full">SOTK</span>
            <h2 class="text-2xl md:text-3xl font-black text-foreground-custom mt-2">Struktur Organisasi & Tata Kerja</h2>
            <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Aparatur pemerintahan Desa Dalangan yang siap melayani kebutuhan warga.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
            @foreach ($this->apparatus as $item)
                <div class="bg-white border border-border-custom rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col items-center text-center gap-3">
                    <div class="w-20 h-20 rounded-full bg-primary/10 overflow-hidden border border-border-custom flex items-center justify-center text-primary font-black text-2xl shadow-sm">
                        @if ($item->image)
                            <img src="{{ HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            {{ collect(str_word_count($item->name, 1))->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))->take(2)->join('') }}
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-foreground-custom">{{ $item->name }}</h3>
                        <span class="text-xs font-semibold text-primary block mt-0.5">{{ $item->position }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
