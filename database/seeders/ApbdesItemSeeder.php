<?php

namespace Database\Seeders;

use App\Enums\ApbdesCategory;
use App\Models\ApbdesItem;
use Illuminate\Database\Seeder;

class ApbdesItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['category' => ApbdesCategory::Pendapatan, 'name' => 'Dana Desa (APBN)', 'amount' => 820_000_000],
            ['category' => ApbdesCategory::Pendapatan, 'name' => 'Alokasi Dana Desa (ADD)', 'amount' => 510_000_000],
            ['category' => ApbdesCategory::Pendapatan, 'name' => 'Pendapatan Asli Desa (PADes)', 'amount' => 210_000_000],
            ['category' => ApbdesCategory::Belanja, 'name' => 'Pembangunan Infrastruktur', 'amount' => 640_000_000],
            ['category' => ApbdesCategory::Belanja, 'name' => 'Pemberdayaan Masyarakat', 'amount' => 420_000_000],
            ['category' => ApbdesCategory::Belanja, 'name' => 'Penyelenggaraan Pemerintahan', 'amount' => 480_000_000],
        ];

        foreach ($items as $item) {
            ApbdesItem::create($item);
        }
    }
}
