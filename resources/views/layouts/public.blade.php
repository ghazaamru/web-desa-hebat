@php
    $visitorToday = \App\Models\Visitor::where('visit_date', now()->toDateString())->count();
    $visitorYesterday = \App\Models\Visitor::where('visit_date', now()->subDay()->toDateString())->count();
    $visitorThisMonth = \App\Models\Visitor::whereMonth('visit_date', now()->month)
        ->whereYear('visit_date', now()->year)
        ->count();
    $visitorTotal = \App\Models\Visitor::count();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script>
            localStorage.setItem('flux.appearance', 'light');
        </script>
        @include('partials.head')
        @stack('styles')
    </head>
    <body class="bg-background-custom text-foreground-custom font-sans antialiased min-h-screen flex flex-col">
        {{-- Public Navbar --}}
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-border-custom px-4 py-3">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5" wire:navigate>
                    <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white font-black text-xl shadow-md border border-white/20">
                        D
                    </div>
                    <div>
                        <span class="block font-black text-base text-foreground-custom leading-none">Desa Dalangan</span>
                        <span class="text-[10px] text-foreground-custom/60 uppercase tracking-widest font-semibold">Portal Resmi</span>
                    </div>
                </a>

                    <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-foreground-custom/80">
                        <a href="{{ route('profil') }}" class="hover:text-primary transition-colors {{ request()->routeIs('profil') ? 'text-primary font-bold' : '' }}" wire:navigate>Profil Desa</a>
                        <a href="{{ route('home') }}#layanan" class="hover:text-primary transition-colors">Layanan Publik</a>
                        <a href="{{ route('peta-potensi') }}" class="hover:text-primary transition-colors {{ request()->routeIs('peta-potensi') ? 'text-primary font-bold' : '' }}" wire:navigate>Peta Potensi</a>
                        <a href="{{ route('katalog-usaha') }}" class="hover:text-primary transition-colors {{ request()->routeIs('katalog-usaha') ? 'text-primary font-bold' : '' }}" wire:navigate>Katalog Usaha</a>
                        <a href="{{ route('home') }}#transparansi" class="hover:text-primary transition-colors">APBDes</a>
                        <a href="{{ route('home') }}#berita" class="hover:text-primary transition-colors">Berita</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="flex-grow w-full">
            {{ $slot }}
        </main>

        {{-- Public Footer --}}
        <footer class="mt-auto bg-slate-900 text-slate-400 border-t border-slate-800">
            <div class="max-w-7xl mx-auto w-full px-4 py-12 grid grid-cols-1 md:grid-cols-12 gap-8">
                <!-- Info & Socials -->
                <div class="md:col-span-4 flex flex-col gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5" wire:navigate>
                        <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white font-black text-xl shadow-md border border-white/20">
                            D
                        </div>
                        <span class="font-black text-base text-white leading-none">Desa Dalangan</span>
                    </a>
                    <p class="text-xs text-slate-400/90 leading-relaxed max-w-sm">
                        Website pelayanan digital resmi untuk mendukung tata kelola pemerintahan yang bersih, transparan, dan berorientasi pada pelayanan masyarakat secara prima.
                    </p>
                </div>

                <!-- Office Address & Contact -->
                <div class="md:col-span-3 flex flex-col gap-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Kontak & Alamat</h4>
                    <div class="flex flex-col gap-2.5 text-xs">
                        <div class="flex gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Jl. Raya Desa Dalangan No. 12, Kec. Tawangsari, Kabupaten Sukoharjo, 12345</span>
                        </div>
                        <div class="flex gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Senin - Jumat | 08:00 - 15:30 WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Visitor Statistics -->
                <div class="md:col-span-3 flex flex-col gap-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Kunjungan Website</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="flex flex-col">
                            <span class="text-slate-500 text-[10px] uppercase tracking-wider">Hari Ini</span>
                            <span class="font-bold text-white text-sm mt-0.5">{{ number_format($visitorToday, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-slate-500 text-[10px] uppercase tracking-wider">Kemarin</span>
                            <span class="font-bold text-white text-sm mt-0.5">{{ number_format($visitorYesterday, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-slate-500 text-[10px] uppercase tracking-wider">Bulan Ini</span>
                            <span class="font-bold text-white text-sm mt-0.5">{{ number_format($visitorThisMonth, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-slate-500 text-[10px] uppercase tracking-wider">Total</span>
                            <span class="font-bold text-white text-sm mt-0.5">{{ number_format($visitorTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Support CTA -->
                <div class="md:col-span-2 flex flex-col gap-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Layanan Darurat</h4>
                    <p class="text-xs leading-relaxed">Butuh bantuan segera?</p>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-accent-green hover:bg-accent-green/90 text-white text-xs font-bold rounded-xl transition duration-200 shadow-sm w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Footer copyright bottom -->
            <div class="border-t border-slate-800/80 py-6 px-4">
                <div class="max-w-7xl mx-auto w-full text-center sm:text-left text-[11px]">
                    <span>© {{ date('Y') }} Pemerintah Desa Dalangan. Seluruh Hak Cipta Dilindungi.</span>
                </div>
            </div>
        </footer>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
        @stack('scripts')
    </body>
</html>