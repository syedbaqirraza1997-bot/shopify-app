<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Popup;
use App\Models\Analytics;

class DashboardController extends Controller
{
    /**
     * Dashboard dikhana
     */
    public function index()
    {
        $shopDomain = Session::get('shop_domain');
        
        // Shop ki information
        $shop = Shop::where('shop_domain', $shopDomain)->first();
        
        // Statistics
        $totalReviews = Review::where('shop_domain', $shopDomain)->count();
        $pendingReviews = Review::where('shop_domain', $shopDomain)->where('status', 'pending')->count();
        $approvedReviews = Review::where('shop_domain', $shopDomain)->where('status', 'approved')->count();
        
        $totalPopups = Popup::where('shop_domain', $shopDomain)->count();
        $popupViews = Popup::where('shop_domain', $shopDomain)->sum('display_count');
        
        // Recent activity
        $recentReviews = Review::where('shop_domain', $shopDomain)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'shop',
            'totalReviews',
            'pendingReviews',
            'approvedReviews',
            'totalPopups',
            'popupViews',
            'recentReviews'
        ));
    }
}
