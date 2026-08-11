<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && ! $request->ajax()) {
            $ip = $request->ip();
            $date = now()->toDateString();
            $path = '/'.ltrim($request->getPathInfo(), '/');

            try {
                Visitor::create([
                    'ip_address' => $ip,
                    'visit_date' => $date,
                ]);
            } catch (\Exception $e) {
                // Unique constraint failed, already visited today
            }

            try {
                PageView::create([
                    'ip_address' => $ip,
                    'path' => $path,
                ]);
            } catch (\Exception $e) {
                // Silent
            }
        }

        return $next($request);
    }
}
