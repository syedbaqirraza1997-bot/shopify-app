<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Review;
use App\Models\Popup;
use App\Models\Analytics;

class WidgetController extends Controller
{
    /**
     * Widget configuration (public)
     */
    public function config(Request $request)
    {
        $shop = $request->get('shop');
        
        if (!$shop) {
            return response()->json(['error' => 'Shop required'], 400);
        }
        
        $settings = Settings::where('shop_domain', $shop)->first();
        
        if (!$settings) {
            return response()->json(['error' => 'Settings not found'], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'salesPopup' => [
                    'enabled' => $settings->sales_popup_enabled,
                    'position' => $settings->sales_popup_position,
                    'displayDuration' => $settings->sales_popup_duration,
                    'delayBetweenPopups' => $settings->sales_popup_delay,
                    'maxPopupsPerSession' => $settings->sales_popup_max,
                    'showOnMobile' => $settings->sales_popup_mobile,
                    'animation' => $settings->sales_popup_animation,
                    'dataSource' => $settings->sales_popup_data_source,
                    'template' => $settings->sales_popup_template,
                ],
                'reviews' => [
                    'enabled' => $settings->reviews_enabled,
                    'reviewsPerPage' => $settings->reviews_per_page,
                    'showVerifiedBadge' => $settings->reviews_show_verified,
                    'starColor' => $settings->reviews_star_color,
                ],
                'socialProof' => [
                    'enabled' => $settings->social_proof_enabled,
                    'viewersCount' => [
                        'enabled' => $settings->viewers_enabled,
                        'minCount' => $settings->viewers_min,
                        'maxCount' => $settings->viewers_max,
                    ],
                    'stockCount' => [
                        'enabled' => $settings->stock_enabled,
                        'threshold' => $settings->stock_threshold,
                    ],
                ],
                'trustBadges' => [
                    'enabled' => $settings->trust_badges_enabled,
                    'position' => $settings->trust_badges_position,
                    'badges' => json_decode($settings->trust_badges, true) ?? [],
                ],
                'urgency' => [
                    'enabled' => $settings->urgency_enabled,
                    'countdownTimer' => [
                        'enabled' => $settings->timer_enabled,
                        'message' => $settings->timer_message,
                    ],
                    'stockIndicator' => [
                        'enabled' => $settings->stock_urgency_enabled,
                        'message' => $settings->stock_urgency_message,
                        'lowStockThreshold' => $settings->stock_urgency_threshold,
                    ],
                ],
                'general' => [
                    'primaryColor' => $settings->primary_color,
                    'mobileOptimized' => $settings->mobile_optimized,
                ],
            ]
        ]);
    }
    
    /**
     * Get reviews for a product (public)
     */
    public function getReviews(Request $request)
    {
        $shop = $request->get('shop');
        $productId = $request->get('productId');
        $page = $request->get('page', 1);
        
        if (!$shop || !$productId) {
            return response()->json(['error' => 'Shop and productId required'], 400);
        }
        
        $reviews = Review::where('shop_domain', $shop)
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calculate average rating
        $averageRating = Review::where('shop_domain', $shop)
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->avg('rating') ?? 0;
        
        $totalReviews = Review::where('shop_domain', $shop)
            ->where('product_id', $productId)
            ->where('status', 'approved')
            ->count();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'reviews' => $reviews,
                'summary' => [
                    'averageRating' => round($averageRating, 1),
                    'totalReviews' => $totalReviews,
                ],
            ]
        ]);
    }
    
    /**
     * Submit a review (public)
     */
    public function submitReview(Request $request)
    {
        $shop = $request->input('shop');
        
        if (!$shop) {
            return response()->json(['error' => 'Shop required'], 400);
        }
        
        $settings = Settings::where('shop_domain', $shop)->first();
        
        $review = new Review();
        $review->shop_domain = $shop;
        $review->product_id = $request->input('productId');
        $review->product_title = $request->input('productTitle', 'Unknown Product');
        $review->rating = $request->input('rating', 5);
        $review->title = $request->input('title', '');
        $review->content = $request->input('content', '');
        $review->customer_name = $request->input('reviewer.name', 'Anonymous');
        $review->customer_email = $request->input('reviewer.email', '');
        $review->status = $settings && $settings->reviews_require_approval ? 'pending' : 'approved';
        $review->save();
        
        return response()->json([
            'status' => 'success',
            'message' => $review->status === 'pending' ? 'Review submitted for approval' : 'Review published',
            'data' => $review,
        ]);
    }
    
    /**
     * Get popups (public)
     */
    public function getPopups(Request $request)
    {
        $shop = $request->get('shop');
        $limit = $request->get('limit', 10);
        
        if (!$shop) {
            return response()->json(['error' => 'Shop required'], 400);
        }
        
        $popups = Popup::where('shop_domain', $shop)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $popups,
        ]);
    }
    
    /**
     * Track analytics event (public)
     */
    public function trackEvent(Request $request)
    {
        $shop = $request->input('shop');
        
        if (!$shop) {
            return response()->json(['error' => 'Shop required'], 400);
        }
        
        $analytics = new Analytics();
        $analytics->shop_domain = $shop;
        $analytics->event_type = $request->input('eventType');
        $analytics->category = $request->input('category', 'general');
        $analytics->product_id = $request->input('productId');
        $analytics->metadata = json_encode($request->input('metadata', []));
        $analytics->ip_address = $request->ip();
        $analytics->user_agent = $request->header('User-Agent');
        $analytics->save();
        
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Widget script (public)
     */
    public function script(Request $request)
    {
        $shop = $request->get('shop');
        
        $script = file_get_contents(public_path('widgets/main.js'));
        
        return response($script)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=300');
    }
    
    /**
     * Widget styles (public)
     */
    public function styles(Request $request)
    {
        $shop = $request->get('shop');
        $settings = Settings::where('shop_domain', $shop)->first();
        
        $primaryColor = $settings ? $settings->primary_color : '#008060';
        $customCSS = $settings ? $settings->custom_css : '';
        
        $css = file_get_contents(public_path('widgets/styles.css'));
        $css = str_replace('{{primary_color}}', $primaryColor, $css);
        $css .= "\n" . $customCSS;
        
        return response($css)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'public, max-age=300');
    }
}
