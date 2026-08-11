<?php

namespace Database\Seeders;

use App\Models\VillageStatistic;
use Illuminate\Database\Seeder;

class VillageStatisticSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Total Penduduk', 'value' => '4.250', 'sort_order' => 0],
            ['label' => 'Luas Wilayah', 'value' => '12,5 km²', 'sort_order' => 1],
            ['label' => 'Kepala Keluarga', 'value' => '1.120', 'sort_order' => 2],
            ['label' => 'Jumlah RT / RW', 'value' => '6 / 24', 'sort_order' => 3],
            ['label' => 'Hero Image', 'value' => 'https://images.unsplash.com/photo-1596422846543-75c6fc18a523?auto=format&fit=crop&q=80&w=800', 'sort_order' => 99],
            ['label' => 'Visi', 'value' => 'Terwujudnya Desa Dalangan yang maju, mandiri, sejahtera, dan demokratis melalui pelayanan digital serta pembangunan infrastruktur yang merata.', 'sort_order' => 100],
            ['label' => 'Misi', 'value' => "1. Meningkatkan tata kelola pemerintahan desa yang bersih, transparan, dan berorientasi pelayanan publik berbasis digital.\n2. Mempercepat pembangunan infrastruktur jalan, irigasi, dan sarana publik desa.\n3. Mengembangkan potensi ekonomi lokal melalui pemberdayaan UMKM, kelompok tani, dan BUMDes.\n4. Meningkatkan kualitas kehidupan keagamaan, sosial, budaya, dan pendidikan masyarakat desa.", 'sort_order' => 101],
            ['label' => 'Sejarah', 'value' => 'Desa Dalangan didirikan pada masa kolonial Belanda sebagai daerah pertanian yang subur. Nama Dalangan berasal dari sejarah panjang persinggahan para dalang wayang kulit tempo dulu yang kerap berkumpul di bawah pohon beringin pusat desa. Seiring perkembangan waktu, Dalangan terus tumbuh menjadi pusat pertanian padi di Tawangsari hingga kini bertransformasi menjadi desa digital mandiri.', 'sort_order' => 102],
        ];

        foreach ($items as $item) {
            VillageStatistic::create($item);
        }
    }
}
