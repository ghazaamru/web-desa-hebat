<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Desa Modern - Portal Resmi Desa Hebat</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background-custom text-foreground-custom font-sans antialiased min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-border-custom px-4 py-3">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        D
                    </div>
                    <span class="font-bold text-lg text-foreground-custom tracking-tight">Desa Hebat</span>
                </a>

                <div class="flex items-center gap-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-secondary transition duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-foreground-custom hover:bg-muted-custom text-xs font-semibold rounded-lg transition duration-200">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-secondary transition duration-200 shadow-sm">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative px-4 py-12 md:py-20 max-w-7xl mx-auto w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="flex flex-col gap-6 text-left">
                <span class="inline-flex self-start items-center gap-1.5 px-3 py-1 bg-accent-green/10 text-accent-green text-xs font-semibold rounded-full border border-accent-green/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Sistem Layanan Mandiri Desa
                </span>
                <h1 class="text-3xl md:text-5xl font-black text-foreground-custom leading-tight">
                    Layanan Mandiri <br class="hidden md:inline" />
                    <span class="text-primary">Desa Hebat</span> Kini Lebih Dekat
                </h1>
                <p class="text-sm md:text-base text-foreground-custom/75 max-w-md leading-relaxed">
                    Ajukan surat pengantar, pantau bansos, laporkan aspirasi, dan hubungi perangkat desa langsung dari ponsel Anda. Layanan 24 jam non-stop, cepat, dan transparan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-accent-green text-white font-bold text-sm rounded-xl hover:bg-accent-green/90 transition duration-200 shadow-md">
                        Mulai Layanan Mandiri
                    </a>
                    <a href="#layanan" class="px-6 py-3 bg-white text-foreground-custom border border-border-custom font-bold text-sm rounded-xl hover:bg-muted-custom transition duration-200 shadow-sm">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
            
            <!-- Mobile-first Interactive Visual Placeholder -->
            <div class="relative w-full aspect-square md:aspect-auto md:h-[400px] bg-white border border-border-custom rounded-3xl p-6 shadow-xl flex flex-col justify-between overflow-hidden">
                <!-- Decorative Pattern -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-secondary/15 rounded-full blur-2xl"></div>

                <!-- Top bar of simulation -->
                <div class="flex items-center justify-between border-b border-border-custom pb-4 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary/15 flex items-center justify-center text-primary font-bold">
                            DH
                        </div>
                        <div>
                            <div class="font-bold text-xs">Pemerintah Desa Hebat</div>
                            <div class="text-[10px] text-foreground-custom/50 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-accent-green animate-pulse"></span>
                                Layanan Aktif
                            </div>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-muted-custom flex items-center justify-center text-foreground-custom/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>

                <!-- Simulated widget/form -->
                <div class="my-auto flex flex-col gap-3 relative z-10">
                    <div class="bg-muted-custom p-4 rounded-2xl border border-border-custom">
                        <div class="text-[10px] uppercase font-bold text-foreground-custom/40 tracking-wider mb-2">Paling Sering Digunakan</div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white p-3 rounded-xl border border-border-custom/50 flex items-center gap-2 hover:border-primary transition cursor-pointer">
                                <div class="p-1.5 rounded-lg bg-primary/10 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-bold">Surat Pengantar</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-border-custom/50 flex items-center gap-2 hover:border-primary transition cursor-pointer">
                                <div class="p-1.5 rounded-lg bg-accent-green/10 text-accent-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-bold">Bantuan Sosial</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-2xl border border-border-custom/80 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-accent-green flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold">Tanya Perangkat Desa</div>
                                <div class="text-[10px] text-foreground-custom/40">Respon rata-rata: <span class="font-bold">15 menit</span></div>
                            </div>
                        </div>
                        <a href="https://wa.me/#" class="px-3 py-1.5 bg-accent-green text-white text-[10px] font-bold rounded-lg hover:bg-accent-green/90 transition">Hubungi</a>
                    </div>
                </div>

                <!-- Footer of simulation -->
                <div class="border-t border-border-custom pt-4 text-center text-[10px] text-foreground-custom/40 relative z-10 flex items-center justify-between">
                    <span>Terintegrasi dengan RT/RW & Dukcapil</span>
                    <span class="font-bold text-accent-green">✓ Aman & Resmi</span>
                </div>
            </div>
        </section>

        <!-- Features Grid Section -->
        <section id="layanan" class="bg-white py-12 px-4 border-y border-border-custom">
            <div class="max-w-7xl mx-auto w-full text-center flex flex-col gap-8">
                <div class="flex flex-col gap-2 items-center">
                    <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full">Solusi Mandiri</span>
                    <h2 class="text-2xl md:text-3xl font-black">Layanan Online Administrasi Desa</h2>
                    <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg">Semua urusan berkas, bantuan sosial, dan komunikasi kini berjalan secara transparan dan instan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left mt-4">
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-2xl bg-background-custom border border-border-custom flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base">Pembuatan Surat Pengantar</h3>
                        <p class="text-xs text-foreground-custom/70 leading-relaxed">Pengajuan Surat Pengantar RT/RW, Surat Keterangan Tidak Mampu (SKTM), Domisili, dan lainnya secara online dalam beberapa menit saja.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-2xl bg-background-custom border border-border-custom flex flex-col gap-4">
                        <div class="w-12 h-12 bg-accent-green/10 rounded-xl flex items-center justify-center text-accent-green">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base">Transparansi Bansos</h3>
                        <p class="text-xs text-foreground-custom/70 leading-relaxed">Pantau daftar penerima Bantuan Langsung Tunai (BLT), PKH, BPNT dan bantuan pemerintah lainnya secara adil dan transparan tanpa nepotisme.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-2xl bg-background-custom border border-border-custom flex flex-col gap-4">
                        <div class="w-12 h-12 bg-secondary/15 rounded-xl flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-base">Aspirasi & Aduan Warga</h3>
                        <p class="text-xs text-foreground-custom/70 leading-relaxed">Laporkan lampu jalan mati, jalan rusak, atau masalah ketertiban umum. Laporan diteruskan langsung ke kepala desa dan kepala urusan terkait.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="px-4 py-16 max-w-7xl mx-auto w-full text-center">
            <div class="bg-primary p-8 md:p-12 rounded-3xl text-white flex flex-col items-center gap-6 shadow-xl relative overflow-hidden">
                <!-- Background decorative shapes -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary via-secondary to-primary opacity-50"></div>
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-accent-green/10 rounded-full blur-3xl"></div>

                <h2 class="text-2xl md:text-4xl font-black relative z-10 max-w-2xl leading-tight">
                    Siap Menjadi Bagian Dari Digitalisasi Desa Hebat?
                </h2>
                <p class="text-xs md:text-sm text-white/80 relative z-10 max-w-md">
                    Daftar akun warga menggunakan NIK Anda sekarang untuk mendapatkan akses instan ke seluruh fitur portal.
                </p>
                <div class="flex flex-wrap justify-center gap-3 relative z-10">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-accent-green text-white font-bold text-sm rounded-xl hover:bg-accent-green/90 transition shadow-lg">
                        Daftar Akun Warga
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-white/10 text-white border border-white/20 font-bold text-sm rounded-xl hover:bg-white/20 transition">
                        Masuk Portal
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-auto bg-white border-t border-border-custom py-8 px-4 text-center">
            <div class="max-w-7xl mx-auto w-full flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-foreground-custom/50">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-foreground-custom">Desa Hebat</span>
                    <span>© {{ date('Y') }}. Hak Cipta Dilindungi.</span>
                </div>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-primary transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-primary transition">Kontak Bantuan</a>
                </div>
            </div>
        </footer>
    </body>
</html>
