<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Warga Desa Dalangan Laksanakan Kerja Bakti Gotong Royong Massal',
                'slug' => 'warga-desa-dalangan-laksanakan-kerja-bakti-gotong-royong-massal',
                'excerpt' => 'Menyambut hari kemerdekaan, ratusan warga dari seluruh RW turun ke jalan membersihkan lingkungan desa.',
                'content' => "Menyambut hari kemerdekaan Republik Indonesia, ratusan warga Desa Dalangan dari seluruh RW turun ke jalan membersihkan lingkungan desa.\n\nKegiatan kerja bakti massal ini melibatkan seluruh elemen masyarakat, mulai dari pemuda, ibu-ibu PKK, hingga perangkat desa. Gotong royong ini menjadi wujud nyata semangat kebersamaan dan kepedulian warga terhadap kebersihan serta keindahan lingkungan.",
                'image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&q=80&w=600',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Pelatihan Digitalisasi Administrasi Untuk Perangkat RT/RW',
                'slug' => 'pelatihan-digitalisasi-administrasi-untuk-perangkat-rt-rw',
                'excerpt' => 'Pemerintah desa mengadakan bimbingan teknis penggunaan aplikasi portal pelayanan mandiri demi keakuratan data.',
                'content' => "Pemerintah Desa Dalangan mengadakan bimbingan teknis penggunaan aplikasi portal pelayanan mandiri bagi seluruh perangkat RT/RW.\n\nPelatihan ini bertujuan meningkatkan kualitas pengelolaan data kependudukan dan mempercepat pelayanan administrasi bagi warga. Para peserta diajarkan cara menginput data, memverifikasi pengajuan surat, hingga memantau laporan perkembangan desa secara digital.",
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=600',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Penyaluran BLT Dana Desa Tahap II Selesai Direalisasikan',
                'slug' => 'penyaluran-blt-dana-desa-tahap-ii-selesai-direalisasikan',
                'excerpt' => 'Sebanyak 80 keluarga penerima manfaat (KPM) telah menerima bantuan tunai untuk mendukung ketahanan pangan lokal.',
                'content' => "Pemerintah Desa Dalangan telah menyelesaikan penyaluran Bantuan Langsung Tunai (BLT) Dana Desa tahap II.\n\nSebanyak 80 keluarga penerima manfaat (KPM) telah menerima bantuan tunai yang diperuntukkan mendukung ketahanan pangan dan kebutuhan pokok sehari-hari. Penyaluran dilakukan secara transparan dan tepat sasaran sesuai data terpadu kesejahteraan sosial.",
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600',
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($items as $item) {
            News::create($item);
        }
    }
}
