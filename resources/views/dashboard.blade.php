<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading size="xl">Dashboard</flux:heading>
                <flux:text>Ringkasan aktivitas dan data Desa Dalangan.</flux:text>
            </div>
            <flux:button variant="primary" icon="pencil-square" :href="route('manage-content')" wire:navigate>
                Kelola Konten
            </flux:button>
        </div>

        <!-- Visitor & Traffic Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pengunjung Hari Ini</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($visitorsToday, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pengunjung Bulan Ini</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($visitorsMonth, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Pengunjung</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($visitorsTotal, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Klik Halaman</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($totalHits, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Content Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Berita</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($newsCount, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aduan Pending</span>
                <span class="text-2xl font-black {{ $pendingComplaints > 0 ? 'text-amber-500' : 'text-foreground-custom' }}">{{ number_format($pendingComplaints, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Potensi &amp; UMKM</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($potencyCount, 0, ',', '.') }}</span>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-1">
                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Perangkat Desa</span>
                <span class="text-2xl font-black text-foreground-custom">{{ number_format($apparatusCount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- APBDes Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-2">
                <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pendapatan Desa (APBDes)</span>
                <span class="text-2xl font-black text-primary">Rp {{ number_format($apbdesPendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm flex flex-col gap-2">
                <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Belanja Desa (APBDes)</span>
                <span class="text-2xl font-black text-accent-green">Rp {{ number_format($apbdesBelanja, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</x-layouts::app>
