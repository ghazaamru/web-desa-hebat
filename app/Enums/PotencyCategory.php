<?php

namespace App\Enums;

enum PotencyCategory: string
{
    case Bumdes = 'bumdes';
    case Umkm = 'umkm';
    case Wisata = 'wisata';
    case Fasilitas = 'fasilitas';

    public function label(): string
    {
        return match ($this) {
            self::Bumdes => 'BUMDes',
            self::Umkm => 'UMKM',
            self::Wisata => 'Wisata',
            self::Fasilitas => 'Fasilitas',
        };
    }
}
