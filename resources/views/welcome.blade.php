<x-layouts::public>
    <!-- Leaflet.js CSS for Village Map (pushed to layouts.public head) -->
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    <!-- Hero Section -->
    <section class="relative px-4 py-12 md:py-24 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 flex flex-col gap-6 text-left relative z-10">
                <span class="inline-flex self-start items-center gap-1.5 px-3 py-1 bg-accent-green/10 text-accent-green text-xs font-bold rounded-full border border-accent-green/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent-green animate-pulse"></span>
                    Kecamatan Tawangsari, Kabupaten Sukoharjo
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-6xl font-black text-foreground-custom leading-tight">
                    Membangun Desa <br class="hidden sm:inline" />
                    <span class="text-primary bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Digital & Mandiri</span>
                </h1>
                <p class="text-sm md:text-base text-foreground-custom/75 max-w-xl leading-relaxed">
                    Selamat datang di website pelayanan resmi Desa Dalangan. Dapatkan kemudahan pelayanan dokumen administratif, pemantauan dana desa, aduan masyarakat, hingga informasi UMKM lokal dalam satu pintu secara digital.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#layanan" class="px-6 py-3 bg-accent-green hover:bg-accent-green/90 text-white font-bold text-sm rounded-xl transition duration-200 shadow-md inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Ajukan Dokumen
                    </a>
                    <a href="{{ route('pengaduan.create') }}" class="px-6 py-3 bg-white text-foreground-custom border border-border-custom font-bold text-sm rounded-xl hover:bg-muted-custom transition duration-200 shadow-sm inline-flex items-center gap-2" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Laporkan Aduan
                    </a>
                </div>
            </div>
            
            <!-- Hero Image Visual Placeholder -->
            <div class="lg:col-span-5 relative w-full aspect-video lg:aspect-square bg-slate-200 rounded-3xl overflow-hidden shadow-xl border border-border-custom flex items-center justify-center">
                <div class="absolute inset-0 bg-gradient-to-tr from-slate-900 via-slate-800/80 to-transparent z-10"></div>
                <img src="{{ $heroImage }}" alt="Suasana Pedesaan Indonesia" class="absolute inset-0 w-full h-full object-cover">
                
                <div class="absolute bottom-6 left-6 right-6 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-lg flex items-center justify-between">
                    <div>
                        <div class="font-black text-xs text-foreground-custom">Balai Desa Dalangan</div>
                        <div class="text-[10px] text-foreground-custom/60">Pusat Administrasi & Pelayanan</div>
                    </div>
                    <span class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-lg border border-primary/20">Buka Hari Ini</span>
                </div>
            </div>
        </section>

        <!-- Demographic Stats Section -->
        <section id="tentang" class="px-4 py-8 max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($statistics as $stat)
                    <div class="bg-white p-5 rounded-2xl border border-border-custom shadow-sm flex flex-col gap-1 text-center md:text-left">
                        <span class="text-2xl md:text-3xl font-black text-primary">{{ $stat->value }}</span>
                        <span class="text-xs font-semibold text-foreground-custom/60 uppercase tracking-wider">{{ $stat->label }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        @if ($kepalaDesa)
            <!-- Welcome Message Section -->
            <section id="sambutan" class="bg-white py-12 px-4 border-t border-border-custom">
                <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-4 flex flex-col items-center text-center">
                        <div class="w-48 h-48 rounded-3xl bg-primary/10 overflow-hidden border border-border-custom flex items-center justify-center text-primary font-black text-5xl shadow-md">
                            @if ($kepalaDesa->image)
                                <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($kepalaDesa->image) }}" alt="{{ $kepalaDesa->name }}" class="w-full h-full object-cover">
                            @else
                                {{ collect(str_word_count($kepalaDesa->name, 1))->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))->take(2)->join('') }}
                            @endif
                        </div>
                        <h3 class="font-black text-lg text-foreground-custom mt-4">{{ $kepalaDesa->name }}</h3>
                        <span class="text-xs font-bold text-primary uppercase tracking-wider">{{ $kepalaDesa->position }} Dalangan</span>
                    </div>
                    <div class="lg:col-span-8 flex flex-col gap-4 text-left">
                        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Sambutan</span>
                        <h2 class="text-2xl md:text-3xl font-black">Selamat Datang di Portal Resmi Desa Dalangan</h2>
                        <div class="text-sm md:text-base text-foreground-custom/75 leading-relaxed space-y-4">
                            <p class="italic">"{{ $kepalaDesa->welcome_message }}"</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Public Services Section -->
        <section id="layanan" class="px-4 py-12 max-w-7xl mx-auto w-full flex flex-col gap-8">
            <div class="text-center flex flex-col gap-2">
                <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Administrasi</span>
                <h2 class="text-2xl md:text-3xl font-black">Layanan Publik Utama</h2>
                <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg self-center">Ajukan berkas-berkas penting di bawah ini secara instan melalui sistem online mandiri warga.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Service Card 1 -->
                <div class="p-6 rounded-2xl bg-white border border-border-custom shadow-sm hover:shadow-md transition flex flex-col gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Kartu Identitas (KTP & KK)</h3>
                        <p class="text-xs text-foreground-custom/75 mt-1 leading-relaxed">Panduan dan pengajuan berkas pengantar untuk penerbitan KTP, Kartu Keluarga baru, atau pembaruan data kependudukan.</p>
                    </div>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-primary hover:text-secondary inline-flex items-center gap-1 mt-auto">
                        Mulai Pengajuan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="p-6 rounded-2xl bg-white border border-border-custom shadow-sm hover:shadow-md transition flex flex-col gap-4">
                    <div class="w-12 h-12 bg-accent-green/10 rounded-xl flex items-center justify-center text-accent-green">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Surat Keterangan Tidak Mampu</h3>
                        <p class="text-xs text-foreground-custom/75 mt-1 leading-relaxed">Layanan pengajuan SKTM bagi warga yang membutuhkan keringanan biaya pendidikan, pengobatan medis, atau urusan sosial.</p>
                    </div>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-primary hover:text-secondary inline-flex items-center gap-1 mt-auto">
                        Mulai Pengajuan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="p-6 rounded-2xl bg-white border border-border-custom shadow-sm hover:shadow-md transition flex flex-col gap-4">
                    <div class="w-12 h-12 bg-secondary/15 rounded-xl flex items-center justify-center text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Surat Izin Usaha Mikro</h3>
                        <p class="text-xs text-foreground-custom/75 mt-1 leading-relaxed">Pengajuan Surat Keterangan Usaha (SKU) resmi dari desa untuk mempermudah perizinan usaha mikro dan akses pembiayaan bank.</p>
                    </div>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-primary hover:text-secondary inline-flex items-center gap-1 mt-auto">
                        Mulai Pengajuan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Interactive Village Map Section -->
        <section id="peta" class="bg-white py-12 px-4 border-t border-border-custom">
            <div class="max-w-7xl mx-auto w-full flex flex-col gap-6">
                <div class="text-center flex flex-col gap-2">
                    <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Geografis</span>
                    <h2 class="text-2xl md:text-3xl font-black">Peta Interaktif Desa Dalangan</h2>
                    <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg self-center">Cari dan temukan lokasi kantor pelayanan, fasilitas umum, sekolah, serta destinasi wisata desa.</p>
                </div>

                <!-- Map Filter Buttons UI -->
                <div class="flex flex-wrap justify-center gap-2 mb-2">
                    <button onclick="filterMap('all')" id="btn-all" class="px-4 py-2 text-xs font-bold rounded-xl border border-primary bg-primary text-white transition cursor-pointer">
                        Semua Lokasi
                    </button>
                    @foreach (\App\Enums\PotencyCategory::cases() as $mapCategory)
                        <button onclick="filterMap('{{ $mapCategory->value }}')" id="btn-{{ $mapCategory->value }}" class="px-4 py-2 text-xs font-bold rounded-xl border border-border-custom bg-background-custom hover:bg-muted-custom text-foreground-custom/80 transition cursor-pointer">
                            {{ $mapCategory->label() }}
                        </button>
                    @endforeach
                </div>

                <!-- Leaflet Map Container -->
                <div class="w-full h-[400px] md:h-[500px] bg-slate-100 rounded-3xl border border-border-custom shadow-inner overflow-hidden relative z-10" id="village-map"></div>
            </div>
        </section>

        <!-- APBDes Transparency Section -->
        <section id="transparansi" class="bg-white py-12 px-4 border-y border-border-custom">
            <div class="max-w-7xl mx-auto w-full flex flex-col gap-8">
                <div class="text-center flex flex-col gap-2">
                    <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Transparansi</span>
                    <h2 class="text-2xl md:text-3xl font-black">Realisasi APBDes {{ date('Y') }}</h2>
                    <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg self-center">Laporan alokasi anggaran pendapatan dan pengeluaran belanja pembangunan Desa Dalangan demi keterbukaan publik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                    <!-- Column 1: Pendapatan -->
                    <div class="p-6 rounded-2xl bg-background-custom border border-border-custom flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="font-black text-sm uppercase tracking-wider text-foreground-custom/50">Sumber Pendapatan Desa</span>
                            <span class="font-black text-xs text-primary">Total: Rp {{ number_format($apbdesPendapatanTotal, 0, ',', '.') }}</span>
                        </div>

                        @foreach ($pendapatan as $item)
                            <div class="flex flex-col gap-1.5">
                                <div class="flex justify-between text-xs font-bold">
                                    <span>{{ $item->name }}</span>
                                    <span>Rp {{ number_format($item->amount, 0, ',', '.') }} ({{ round(($item->amount / max($apbdesPendapatanTotal, 1)) * 100) }}%)</span>
                                </div>
                                <div class="w-full h-3 bg-white border border-border-custom rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full" style="width: {{ round(($item->amount / max($apbdesPendapatanTotal, 1)) * 100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Column 2: Pengeluaran -->
                    <div class="p-6 rounded-2xl bg-background-custom border border-border-custom flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="font-black text-sm uppercase tracking-wider text-foreground-custom/50">Realisasi Belanja Desa</span>
                            <span class="font-black text-xs text-accent-green">Realisasi: {{ round(($apbdesBelanjaTotal / max($apbdesPendapatanTotal, 1)) * 100) }}%</span>
                        </div>

                        @foreach ($belanja as $item)
                            <div class="flex flex-col gap-1.5">
                                <div class="flex justify-between text-xs font-bold">
                                    <span>{{ $item->name }}</span>
                                    <span>Rp {{ number_format($item->amount, 0, ',', '.') }} ({{ round(($item->amount / max($apbdesBelanjaTotal, 1)) * 100) }}%)</span>
                                </div>
                                <div class="w-full h-3 bg-white border border-border-custom rounded-full overflow-hidden">
                                    <div class="h-full bg-accent-green rounded-full" style="width: {{ round(($item->amount / max($apbdesBelanjaTotal, 1)) * 100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- UMKM & Tourism Section -->
        <section id="umkm-wisata" class="px-4 py-12 max-w-7xl mx-auto w-full flex flex-col gap-8">
            <div class="text-center flex flex-col gap-2">
                <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Potensi Desa</span>
                <h2 class="text-2xl md:text-3xl font-black">UMKM & Destinasi Wisata</h2>
                <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg self-center">Dukung pertumbuhan ekonomi kreatif warga desa dengan mengenal produk unggulan dan spot pariwisata terbaik kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($umkmWisata as $item)
                    <div class="bg-white border border-border-custom rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                        <div class="aspect-video w-full relative">
                            @if ($item->image)
                                <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $item->category->label() }}</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 px-2 py-1 text-[10px] font-bold rounded-md text-white {{ $item->category === \App\Enums\PotencyCategory::Wisata ? 'bg-primary' : 'bg-accent-green' }}">{{ $item->category->label() }}</span>
                        </div>
                        <div class="p-4 flex flex-col gap-2 grow">
                            <h3 class="font-bold text-sm">{{ $item->title }}</h3>
                            <p class="text-[11px] text-foreground-custom/75 leading-relaxed">{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Latest News Section -->
        <section id="berita" class="bg-white py-12 px-4 border-t border-border-custom">
            <div class="max-w-7xl mx-auto w-full flex flex-col gap-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="text-left flex flex-col gap-2">
                        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Kabar Desa</span>
                        <h2 class="text-2xl md:text-3xl font-black">Artikel & Berita Terbaru</h2>
                        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg">Ikuti perkembangan terbaru kegiatan pembangunan, pengumuman, dan acara sosial di Desa Dalangan.</p>
                    </div>
                    <a href="{{ route('berita.index') }}" class="text-xs font-bold text-primary hover:text-secondary inline-flex items-center gap-1 self-start md:self-auto" wire:navigate>
                        Lihat Semua Berita
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($news as $item)
                        <div class="bg-background-custom border border-border-custom rounded-2xl overflow-hidden shadow-sm flex flex-col h-full">
                            <a href="{{ route('berita.show', $item->slug) }}" class="block aspect-video w-full overflow-hidden">
                                @if ($item->image)
                                    <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center hover:scale-105 transition duration-300">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Berita Desa</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-5 flex flex-col gap-2.5 grow">
                                <span class="text-[10px] font-bold text-foreground-custom/40">{{ strtoupper($item->published_at?->translatedFormat('d F Y')) }}</span>
                                <h3 class="font-bold text-sm hover:text-primary transition">
                                    <a href="{{ route('berita.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <p class="text-[11px] text-foreground-custom/75 leading-relaxed">{{ $item->excerpt }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- SOTK Apparatus Section -->
        <section id="pemerintah" class="px-4 py-12 max-w-7xl mx-auto w-full flex flex-col gap-8">
            <div class="text-center flex flex-col gap-2">
                <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Pemerintahan</span>
                <h2 class="text-2xl md:text-3xl font-black">Struktur Organisasi Perangkat Desa</h2>
                <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg self-center">Susunan aparatur Pemerintah Desa Dalangan yang siap melayani masyarakat.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($apparatus as $item)
                    <div class="bg-white border border-border-custom rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col items-center text-center gap-3">
                        <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-2xl">
                            {{ collect(str_word_count($item->name, 1))->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))->take(2)->join('') }}
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-foreground-custom">{{ $item->name }}</h3>
                            <span class="text-xs font-semibold text-primary">{{ $item->position }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="galeri" class="bg-white py-12 px-4 border-t border-border-custom">
            <div class="max-w-7xl mx-auto w-full flex flex-col gap-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="text-left flex flex-col gap-2">
                        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-start">Galeri</span>
                        <h2 class="text-2xl md:text-3xl font-black">Dokumentasi Kegiatan Desa</h2>
                        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg">Menampilkan kegiatan-kegiatan yang berlangsung di Desa Dalangan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($galleries as $item)
                        <div class="bg-background-custom border border-border-custom rounded-2xl overflow-hidden shadow-sm flex flex-col h-full">
                            <div class="aspect-video w-full">
                                <img src="{{ \App\Http\Controllers\HomeController::getDirectImageUrl($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4 flex flex-col gap-1.5 grow">
                                <h3 class="font-bold text-sm">{{ $item->title }}</h3>
                                @if ($item->description)
                                    <p class="text-[11px] text-foreground-custom/75 leading-relaxed">{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Leaflet.js Script (pushed to layouts.public body) -->
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="/js/batas-dusun.js"></script>
        
        <!-- Map Setup Script -->
        <script>
            (function () {
                let villageMap = null;

                function initVillageMap() {
                    // Wait for Leaflet to be ready (it may load asynchronously under wire:navigate)
                    if (typeof L === 'undefined' || !document.getElementById('village-map')) {
                        return setTimeout(initVillageMap, 100);
                    }

                    const mapEl = document.getElementById('village-map');
                    if (mapEl._leaflet_id) return; // already initialized

                    // Coordinates of Desa Dalangan (Central)
                    villageMap = L.map(mapEl).setView([-7.720345, 110.817327], 15);

                    // Add standard OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(villageMap);

                    // Render boundary GeoJSON (if available)
                    if (typeof json_BatasDusun_1 !== 'undefined') {
                        L.geoJSON(json_BatasDusun_1, {
                            style: {
                                color: '#0284C7',
                                fillColor: '#0ea5e9',
                                fillOpacity: 0.15,
                                weight: 2
                            }
                        }).addTo(villageMap);
                    }

                    renderMarkers('all');

                    // Fix blank map if the container had no size when initialized
                    villageMap.whenReady(() => setTimeout(() => villageMap.invalidateSize(), 100));
                    window.addEventListener('resize', () => villageMap && villageMap.invalidateSize());
                }

                // Dynamic locations managed from the admin panel (Potency model)
                const locations = @js($mapLocations);

                const categoryColors = {
                    bumdes: '#0284c7',
                    umkm: '#059669',
                    wisata: '#d97706',
                    fasilitas: '#7c3aed'
                };

                const activeMarkers = [];

                function renderMarkers(filter) {
                    if (!villageMap) return;

                    // Remove existing active markers
                    activeMarkers.forEach(marker => villageMap.removeLayer(marker));
                    activeMarkers.length = 0;

                    // Add filtered markers
                    locations.forEach(loc => {
                        if (filter === 'all' || loc.category === filter) {
                            const color = categoryColors[loc.category] || '#0284c7';
                            const imgHtml = loc.img
                                ? `<img src="${loc.img}" class="w-full h-24 object-cover rounded-lg border border-slate-200">`
                                : '';
                            const waHtml = loc.whatsapp
                                ? `<a href="https://wa.me/${loc.whatsapp}" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:4px;background:#059669;color:#fff;padding:5px 10px;border-radius:8px;font-size:11px;font-weight:700;text-decoration:none;margin-top:6px">Hubungi Pengelola</a>`
                                : '';
                            const customPopup = `
                                <div style="max-width:220px;font-family:system-ui,sans-serif">
                                    ${imgHtml}
                                    <span style="display:inline-block;background:${color};color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px;margin:4px 0">${loc.categoryLabel}</span>
                                    <div style="font-weight:800;font-size:13px;color:#0f172a">${loc.name}</div>
                                    <p style="font-size:11px;color:#475569;line-height:1.5;margin:4px 0 0">${loc.desc}</p>
                                    ${waHtml}
                                </div>
                            `;
                            const marker = L.marker(loc.coords)
                                .bindPopup(customPopup)
                                .addTo(villageMap);

                            activeMarkers.push(marker);
                        }
                    });
                }

                // Interactive filter categories toggle
                function filterMap(category) {
                    if (!villageMap) return;

                    const btns = ['all', 'bumdes', 'umkm', 'wisata', 'fasilitas'];
                    btns.forEach(btn => {
                        const el = document.getElementById('btn-' + btn);
                        if (!el) return;
                        if (btn === category) {
                            el.className = 'px-4 py-2 text-xs font-bold rounded-xl border border-primary bg-primary text-white transition cursor-pointer';
                        } else {
                            el.className = 'px-4 py-2 text-xs font-bold rounded-xl border border-border-custom bg-background-custom hover:bg-muted-custom text-foreground-custom/80 transition cursor-pointer';
                        }
                    });

                    renderMarkers(category);
                }

                // Expose handlers used by the inline filter buttons
                window.filterMap = filterMap;

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initVillageMap);
                } else {
                    initVillageMap();
                }
            })();
        </script>
    @endpush
</x-layouts::public>
