<?php

use App\Enums\PotencyCategory;
use App\Models\Potency;
use App\Http\Controllers\HomeController;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Title('Peta Potensi Desa')] #[Layout('layouts.public')] class extends Component {
    /** @var array<string, bool> */
    public array $filters = [
        'bumdes' => true,
        'umkm' => true,
        'wisata' => true,
        'fasilitas' => true,
    ];

    /** @return \Illuminate\Database\Eloquent\Collection<int, Potency> */
    #[Computed]
    public function potencies(): \Illuminate\Database\Eloquent\Collection
    {
        $activeCategories = array_keys(array_filter($this->filters));

        if (empty($activeCategories)) {
            return Potency::all();
        }

        return Potency::whereIn('category', $activeCategories)->get();
    }

    /** @return array<int, array<string, mixed>> */
    #[Computed]
    public function mapPotencies(): array
    {
        return $this->potencies->map(fn (Potency $potency) => [
            'name' => $potency->title,
            'category' => $potency->category->value,
            'categoryLabel' => $potency->category->label(),
            'coords' => [(float) $potency->latitude, (float) $potency->longitude],
            'desc' => $potency->description,
            'img' => $potency->image ? HomeController::getDirectImageUrl($potency->image) : null,
            'whatsapp' => $potency->whatsapp,
        ])->values()->all();
    }

    public function updatedFilters(mixed $value, ?string $key = null): void
    {
        $this->dispatch('potencies-updated', potencies: $this->mapPotencies);
    }
}; ?>

<div
    x-data="{
        map: null,
        markers: [],
        boundary: null,
        potencies: @js($this->mapPotencies),
        init() {
            this.initMap();

            window.addEventListener('potencies-updated', (e) => {
                this.potencies = e.detail.potencies;
                this.renderMarkers();
            });
        },
        initMap() {
            // Wait for Leaflet to be ready (it may load asynchronously under wire:navigate)
            if (typeof L === 'undefined' || !this.$refs.map) {
                return setTimeout(() => this.initMap(), 100);
            }

            if (this.map) return; // already initialized

            this.map = L.map(this.$refs.map).setView([-7.720345, 110.817327], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);

            this.boundary = L.geoJSON(json_BatasDusun_1, {
                style: {
                    color: '#0284C7',
                    fillColor: '#0ea5e9',
                    fillOpacity: 0.08,
                    weight: 2,
                    dashArray: '6 4'
                }
            }).addTo(this.map);

            this.renderMarkers();

            // Fix blank map if the container had no size when initialized
            this.map.whenReady(() => setTimeout(() => this.map.invalidateSize(), 100));
            window.addEventListener('resize', () => this.map && this.map.invalidateSize());
        },
        renderMarkers() {
            this.markers.forEach(m => this.map.removeLayer(m));
            this.markers = [];

            const colors = {
                bumdes: { bg: '#0284c7', label: 'BUMDes' },
                umkm:   { bg: '#059669', label: 'UMKM' },
                wisata: { bg: '#d97706', label: 'Wisata' },
                fasilitas: { bg: '#7c3aed', label: 'Fasilitas' }
            };

            this.potencies.forEach(p => {
                const c = colors[p.category] || colors.bumdes;
                const imgHtml = p.img
                    ? `<img src='${p.img}' class='w-full h-24 object-cover rounded-lg border border-slate-200 mb-2'>`
                    : '';
                const popup = `
                    <div style='max-width:220px;font-family:system-ui,sans-serif'>
                        ${imgHtml}
                        <span style='display:inline-block;background:${c.bg};color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px;margin-bottom:4px'>${c.label}</span>
                        <div style='font-weight:800;font-size:13px;margin:4px 0 2px;color:#0f172a'>${p.name}</div>
                        <p style='font-size:11px;color:#475569;line-height:1.5;margin:0 0 8px'>${p.desc}</p>
                        ${p.whatsapp ? `<a href='https://wa.me/${p.whatsapp}' target='_blank' rel='noopener noreferrer' style='display:inline-flex;align-items:center;gap:4px;background:#059669;color:#fff;padding:5px 10px;border-radius:8px;font-size:11px;font-weight:700;text-decoration:none'>Hubungi Pengelola</a>` : ''}
                    </div>`;
                const marker = L.marker(p.coords).bindPopup(popup).addTo(this.map);
                this.markers.push(marker);
            });
        }
    }"
    class="max-w-7xl mx-auto px-4 py-8 w-full space-y-8"
>
    <!-- Header -->
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full self-center">Geografis</span>
        <h1 class="text-3xl md:text-5xl font-black text-foreground-custom">Peta Potensi Desa</h1>
        <p class="text-xs md:text-sm text-foreground-custom/60 max-w-lg mx-auto">Cari dan temukan lokasi kantor pelayanan, fasilitas umum, sekolah, serta destinasi wisata desa.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Sidebar Filters --}}
        <div class="w-full lg:w-64 shrink-0 space-y-4">
            <div class="bg-white border border-border-custom rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-bold text-foreground-custom mb-4">Filter Kategori</h3>

                <div class="space-y-3">
                    @foreach (PotencyCategory::cases() as $cat)
                        <flux:checkbox
                            wire:model.live="filters.{{ $cat->value }}"
                            :label="$cat->label()"
                        />
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-border-custom rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-bold text-foreground-custom mb-2">Keterangan</h3>
                <ul class="space-y-2 text-xs text-foreground-custom/80">
                    <li class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#0284c7] inline-block shrink-0"></span>
                        BUMDes
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#059669] inline-block shrink-0"></span>
                        UMKM
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#d97706] inline-block shrink-0"></span>
                        Wisata
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#7c3aed] inline-block shrink-0"></span>
                        Fasilitas
                    </li>
                </ul>
            </div>
        </div>

        {{-- Map Container --}}
        <div class="flex-1 min-h-[400px] md:min-h-[550px]">
            <div
                wire:ignore
                x-ref="map"
                class="w-full h-full min-h-[400px] md:min-h-[550px] rounded-2xl border border-border-custom shadow-inner z-0"
            ></div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="/js/batas-dusun.js"></script>
@endpush
