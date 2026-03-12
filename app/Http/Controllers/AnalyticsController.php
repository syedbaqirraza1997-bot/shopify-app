<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Analytics;

class AnalyticsController extends Controller
{
    /**
     * Analytics data return karna (API)
     */
    public function getData()
    {
        $shopDomain = Session::get('shop_domain');
        $days = request()->get('days', 30);
        
        $startDate = now()->subDays($days);
        
        // Event counts
        $events = Analytics::where('shop_domain', $shopDomain)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('event_type, COUNT(*) as count')
            ->groupBy('event_type')
            ->get()
            ->pluck('count', 'event_type')
            ->toArray();
        
        // Daily stats
        $dailyStats = Analytics::where('shop_domain', $shopDomain)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => [
                    'totalEvents' => array_sum($events),
                    'popupViews' => $events['popup_view'] ?? 0,
                    'reviewSubmissions' => $events['review_submit'] ?? 0,
                ],
                'events' => $events,
                'dailyStats' => $dailyStats,
            ]
        ]);
    }
}
