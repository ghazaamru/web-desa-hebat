<?php

namespace App\Models;

use App\Enums\PotencyCategory;
use Database\Factories\PotencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potency extends Model
{
    /** @use HasFactory<PotencyFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'latitude',
        'longitude',
        'whatsapp',
        'image',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'category' => PotencyCategory::class,
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }
}
