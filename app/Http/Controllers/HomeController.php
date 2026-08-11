<?php

namespace App\Http\Controllers;

use App\Enums\ApbdesCategory;
use App\Enums\PotencyCategory;
use App\Models\ApbdesItem;
use App\Models\Apparatus;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Potency;
use App\Models\VillageStatistic;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public static function getDirectImageUrl(?string $url): ?string
    {
        if (empty($url)) {
            return $url;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return "https://lh3.googleusercontent.com/d/{$matches[1]}";
            }

            return $url;
        }

        return Storage::url($url);
    }

    public function __invoke(): View
    {
        $pendapatan = ApbdesItem::where('category', ApbdesCategory::Pendapatan)->get();
        $belanja = ApbdesItem::where('category', ApbdesCategory::Belanja)->get();
        $heroImageRaw = VillageStatistic::where('label', 'Hero Image')->value('value') ?? 'https://images.unsplash.com/photo-1596422846543-75c6fc18a523?auto=format&fit=crop&q=80&w=800';

        return view('welcome', [
            'statistics' => VillageStatistic::where('sort_order', '<', 99)->orderBy('sort_order')->get(),
            'heroImage' => self::getDirectImageUrl($heroImageRaw),
            'pendapatan' => $pendapatan,
            'belanja' => $belanja,
            'apbdesPendapatanTotal' => $pendapatan->sum('amount'),
            'apbdesBelanjaTotal' => $belanja->sum('amount'),
            'umkmWisata' => Potency::whereIn('category', [
                PotencyCategory::Umkm,
                PotencyCategory::Wisata,
            ])->get(),
            'mapLocations' => Potency::all()->map(fn (Potency $potency) => [
                'name' => $potency->title,
                'category' => $potency->category->value,
                'categoryLabel' => $potency->category->label(),
                'coords' => [(float) $potency->latitude, (float) $potency->longitude],
                'desc' => $potency->description,
                'img' => $potency->image ? self::getDirectImageUrl($potency->image) : null,
                'whatsapp' => $potency->whatsapp,
            ])->values(),
            'news' => News::whereNotNull('published_at')->latest('published_at')->limit(3)->get(),
            'apparatus' => Apparatus::orderBy('sort_order')->get(),
            'galleries' => Gallery::latest()->limit(6)->get(),
            'kepalaDesa' => Apparatus::where('position', 'Kepala Desa')->whereNotNull('welcome_message')->first(),
        ]);
    }
}
