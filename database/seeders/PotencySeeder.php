<?php

namespace Database\Seeders;

use App\Enums\PotencyCategory;
use App\Models\Potency;
use Illuminate\Database\Seeder;

class PotencySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Kantor Kepala Desa Dalangan',
                'category' => PotencyCategory::Fasilitas,
                'description' => 'Pusat pelayanan administrasi kependudukan dan pemerintahan desa.',
                'latitude' => -7.720345,
                'longitude' => 110.817327,
                'whatsapp' => '6281234567890',
            ],
            [
                'title' => 'Puskesmas Pembantu Desa',
                'category' => PotencyCategory::Fasilitas,
                'description' => 'Fasilitas kesehatan tingkat pertama untuk imunisasi, berobat jalan, dan konsultasi medis.',
                'latitude' => -7.718000,
                'longitude' => 110.813000,
                'whatsapp' => null,
            ],
            [
                'title' => 'SD Negeri 01 Desa Dalangan',
                'category' => PotencyCategory::Fasilitas,
                'description' => 'Sekolah dasar negeri yang mendidik anak-anak generasi penerus desa.',
                'latitude' => -7.723000,
                'longitude' => 110.815000,
                'whatsapp' => null,
            ],
            [
                'title' => 'Pasar Tradisional Desa',
                'category' => PotencyCategory::Fasilitas,
                'description' => 'Pusat perdagangan hasil bumi warga tani, bahan pokok, serta aneka jajanan tradisional.',
                'latitude' => -7.721000,
                'longitude' => 110.821000,
                'whatsapp' => null,
            ],
            [
                'title' => 'BUMDes Makmur Jaya',
                'category' => PotencyCategory::Bumdes,
                'description' => 'Unit usaha milik desa yang mengelola simpan pinjam dan distribusi pupuk bersubsidi.',
                'latitude' => -7.719200,
                'longitude' => 110.819100,
                'whatsapp' => '6281234567891',
            ],
            [
                'title' => 'Keripik Tempe Renyah Ibu Ani',
                'category' => PotencyCategory::Umkm,
                'description' => 'Makanan ringan khas dari olahan tempe kedelai murni tanpa bahan pengawet.',
                'latitude' => -7.721300,
                'longitude' => 110.821500,
                'whatsapp' => '6281234567892',
            ],
            [
                'title' => 'Madu Murni Hutan Dalangan',
                'category' => PotencyCategory::Umkm,
                'description' => 'Madu liar alami berkualitas tinggi dari hutan lindung kawasan desa.',
                'latitude' => -7.722800,
                'longitude' => 110.815200,
                'whatsapp' => '6281234567893',
            ],
            [
                'title' => 'Batik Tulis Desa Dalangan',
                'category' => PotencyCategory::Umkm,
                'description' => 'Kerajinan batik tulis khas motif lokal dengan pewarna alami.',
                'latitude' => -7.718700,
                'longitude' => 110.818800,
                'whatsapp' => '6281234567894',
            ],
            [
                'title' => 'Curug Indah Desa Dalangan',
                'category' => PotencyCategory::Wisata,
                'description' => 'Wisata alam air terjun sejuk dengan area kamping keluarga.',
                'latitude' => -7.726000,
                'longitude' => 110.811000,
                'whatsapp' => '6281234567895',
            ],
            [
                'title' => 'Agrowisata Sawah Terasering',
                'category' => PotencyCategory::Wisata,
                'description' => 'Eduwisata persawahan berundak dengan jalur trekking dan spot foto.',
                'latitude' => -7.716000,
                'longitude' => 110.824000,
                'whatsapp' => '6281234567896',
            ],
        ];

        foreach ($items as $item) {
            Potency::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
