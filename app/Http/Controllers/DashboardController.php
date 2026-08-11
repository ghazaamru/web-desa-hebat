<?php

namespace App\Http\Controllers;

use App\Enums\ApbdesCategory;
use App\Models\ApbdesItem;
use App\Models\Apparatus;
use App\Models\Complaint;
use App\Models\News;
use App\Models\PageView;
use App\Models\Potency;
use App\Models\Visitor;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('dashboard', [
            'visitorsToday' => Visitor::where('visit_date', now()->toDateString())->count(),
            'visitorsMonth' => Visitor::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->count(),
            'visitorsTotal' => Visitor::count(),
            'totalHits' => PageView::count(),
            'newsCount' => News::count(),
            'pendingComplaints' => Complaint::where('status', 'pending')->count(),
            'potencyCount' => Potency::count(),
            'apparatusCount' => Apparatus::count(),
            'apbdesPendapatan' => ApbdesItem::where('category', ApbdesCategory::Pendapatan)->sum('amount'),
            'apbdesBelanja' => ApbdesItem::where('category', ApbdesCategory::Belanja)->sum('amount'),
        ]);
    }
}
