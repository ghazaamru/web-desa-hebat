<?php

use App\Models\Complaint;
use Flux\Flux;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Pengaduan Warga')] #[Layout('layouts.public')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $content = '';
    public string $website = '';
    public bool $submitted = false;

    public function submitComplaint(): void
    {
        if ($this->website !== '') {
            $this->submitted = true;

            return;
        }

        $key = 'complaint-submit:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            Flux::toast(variant: 'danger', text: 'Terlalu banyak pengaduan dalam waktu singkat. Silakan coba lagi beberapa saat lagi.');

            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        RateLimiter::hit($key, 3600);

        Complaint::create([
            'name' => $this->name,
            'email' => $this->email ?: null,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'content' => $this->content,
            'status' => 'pending',
        ]);

        $this->reset(['name', 'email', 'phone', 'subject', 'content']);
        $this->submitted = true;
        Flux::toast(variant: 'success', text: 'Aduan Anda berhasil dikirim ke pemerintah desa.');
    }
}; ?>

<div class="max-w-xl mx-auto px-4 py-8 space-y-6 w-full">
    <!-- Header -->
    <div class="text-center space-y-2 mb-6">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Aspirasi Warga</span>
        <h1 class="text-3xl md:text-4xl font-black text-foreground-custom">Layanan Pengaduan</h1>
        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Kirimkan aduan, aspirasi, atau keluhan Anda secara langsung dan aman kepada Pemerintah Desa Dalangan.</p>
    </div>

    @if ($submitted)
        <div class="p-6 bg-white border border-border-custom rounded-2xl text-center space-y-4 shadow-sm">
            <div class="w-12 h-12 rounded-full bg-accent-green/10 flex items-center justify-center text-accent-green mx-auto text-xl font-bold">✓</div>
            <div class="space-y-1">
                <h3 class="font-black text-foreground-custom text-base">Aduan Berhasil Dikirim</h3>
                <p class="text-xs text-foreground-custom/70">Terima kasih atas laporan Anda. Perangkat desa akan segera meninjau dan memproses laporan ini.</p>
            </div>
            <button wire:click="$set('submitted', false)" class="px-4 py-2 bg-primary hover:bg-primary/95 text-white text-xs font-bold rounded-xl transition shadow-sm cursor-pointer">
                Kirim Laporan Lain
            </button>
        </div>
    @else
        <form wire:submit="submitComplaint" class="space-y-4 bg-white p-6 rounded-2xl border border-border-custom shadow-sm">
            <div class="hidden" aria-hidden="true">
                <label for="website">Jangan diisi</label>
                <input id="website" type="text" tabindex="-1" autocomplete="off" wire:model.defer="website" class="hidden" />
            </div>

            <flux:input label="Nama Lengkap" wire:model="name" required placeholder="Tulis nama lengkap Anda" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input label="Nomor WhatsApp" wire:model="phone" required placeholder="Contoh: 08123456789" />
                <flux:input label="Email (Opsional)" type="email" wire:model="email" placeholder="nama@email.com" />
            </div>

            <flux:input label="Subjek Pengaduan" wire:model="subject" required placeholder="Contoh: Lampu jalan mati di RT 02" />

            <flux:textarea label="Isi Laporan Pengaduan" wire:model="content" rows="6" required placeholder="Tuliskan laporan pengaduan Anda secara lengkap dan jelas..." />

            <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-primary hover:bg-primary/95 text-white font-bold text-sm rounded-xl transition duration-200 shadow-md inline-flex items-center justify-center gap-2 w-full cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>Kirim Pengaduan</span>
                <span wire:loading>Mengirim...</span>
            </button>
        </form>
    @endif
</div>
