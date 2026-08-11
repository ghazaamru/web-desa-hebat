<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Kegiatan Kerja Bakti Bersama Warga',
                'description' => 'Suasana gotong royong membersihkan lingkungan desa bersama seluruh lapisan masyarakat.',
                'image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Panorama Persawahan Desa Dalangan',
                'description' => 'Hamparan sawah hijau yang menjadi sumber penghidupan utama sebagian besar warga.',
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Pelatihan Digitalisasi Perangkat Desa',
                'description' => 'Bimbingan teknis penggunaan aplikasi pelayanan mandiri bagi perangkat RT/RW.',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Pasar Tradisional Desa',
                'description' => 'Aktivitas jual beli hasil bumi di pasar tradisional yang menjadi denyut ekonomi warga.',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Keindahan Alam Curug Desa',
                'description' => 'Destinasi wisata alam air terjun yang menjadi kebanggaan warga Desa Dalangan.',
                'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($items as $item) {
            Gallery::create($item);
        }
    }
}
