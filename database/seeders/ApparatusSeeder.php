<?php

namespace Database\Seeders;

use App\Models\Apparatus;
use Illuminate\Database\Seeder;

class ApparatusSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Bambang Sutrisno',
                'position' => 'Kepala Desa',
                'sort_order' => 0,
                'welcome_message' => 'Selamat datang di website resmi Desa Dalangan. Sebagai Kepala Desa, saya menyambut baik kehadiran portal informasi ini untuk meningkatkan pelayanan mandiri digital, keterbukaan informasi publik, dan sebagai jembatan komunikasi antara pemerintah desa dengan seluruh masyarakat.',
            ],
            ['name' => 'Sri Wahyuni', 'position' => 'Sekretaris Desa', 'sort_order' => 1],
            ['name' => 'Agus Riyanto', 'position' => 'Kepala Urusan Umum', 'sort_order' => 2],
            ['name' => 'Dewi Lestari', 'position' => 'Kepala Urusan Keuangan', 'sort_order' => 3],
            ['name' => 'Joko Prasetyo', 'position' => 'Kepala Urusan Perencanaan', 'sort_order' => 4],
            ['name' => 'Siti Nurjanah', 'position' => 'Kepala Seksi Pemerintahan', 'sort_order' => 5],
            ['name' => 'Suparman', 'position' => 'Kepala Seksi Kesejahteraan', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            Apparatus::create($item);
        }
    }
}
