<?php

namespace App\Enums;

enum ApbdesCategory: string
{
    case Pendapatan = 'pendapatan';
    case Belanja = 'belanja';

    public function label(): string
    {
        return match ($this) {
            self::Pendapatan => 'Pendapatan',
            self::Belanja => 'Belanja',
        };
    }
}
