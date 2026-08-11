<?php

namespace App\Models;

use Database\Factories\VisitorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /** @use HasFactory<VisitorFactory> */
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'visit_date',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
        ];
    }
}
