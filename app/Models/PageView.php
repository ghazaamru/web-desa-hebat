<?php

namespace App\Models;

use Database\Factories\PageViewFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class PageView extends Model
{
    /** @use HasFactory<PageViewFactory> */
    use HasFactory, Prunable;

    protected $fillable = [
        'ip_address',
        'path',
    ];

    /**
     * Get the prunable model query.
     *
     * @return Builder<self>
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subDays(30));
    }
}
