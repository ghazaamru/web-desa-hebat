<?php

namespace App\Models;

use Database\Factories\ApparatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apparatus extends Model
{
    /** @use HasFactory<ApparatusFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'image',
        'sort_order',
        'welcome_message',
    ];
}
