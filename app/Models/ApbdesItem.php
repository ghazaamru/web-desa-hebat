<?php

namespace App\Models;

use App\Enums\ApbdesCategory;
use Database\Factories\ApbdesItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApbdesItem extends Model
{
    /** @use HasFactory<ApbdesItemFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'amount',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'category' => ApbdesCategory::class,
            'amount' => 'decimal:2',
        ];
    }
}
