<?php

namespace App\Models;

use Database\Factories\VillageStatisticFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageStatistic extends Model
{
    /** @use HasFactory<VillageStatisticFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'value',
        'icon',
        'sort_order',
    ];
}
