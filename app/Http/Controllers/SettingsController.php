<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * General Settings page
     */
    public function index()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        return view('settings', compact('settings'));
    }
    
    /**
     * Settings update karna
     */
    public function update(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        if (!$settings) {
            $settings = new Settings();
            $settings->shop_domain = $shopDomain;
        }
        
        // General settings
        $settings->primary_color = $request->input('primary_color', '#008060');
        $settings->custom_css = $request->input('custom_css', '');
        $settings->mobile_optimized = $request->boolean('mobile_optimized', true);
        
        // Reviews settings
        $settings->reviews_require_approval = $request->boolean('reviews_require_approval', true);
        $settings->reviews_allow_photos = $request->boolean('reviews_allow_photos', true);
        $settings->reviews_allow_videos = $request->boolean('reviews_allow_videos', true);
        $settings->reviews_per_page = $request->input('reviews_per_page', 10);
        
        $settings->save();
        
        return redirect()->route('settings')->with('success', 'Settings saved successfully!');
    }
    
    /**
     * Social Proof settings
     */
    public function socialProof()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        return view('social-proof', compact('settings'));
    }
    
    public function updateSocialProof(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $settings->social_proof_enabled = $request->boolean('social_proof_enabled', true);
        $settings->viewers_enabled = $request->boolean('viewers_enabled', true);
        $settings->viewers_min = $request->input('viewers_min', 5);
        $settings->viewers_max = $request->input('viewers_max', 50);
        $settings->stock_enabled = $request->boolean('stock_enabled', true);
        $settings->stock_threshold = $request->input('stock_threshold', 10);
        $settings->trending_enabled = $request->boolean('trending_enabled', true);
        $settings->trending_min_orders = $request->input('trending_min_orders', 10);
        
        $settings->save();
        
        return redirect()->route('social-proof')->with('success', 'Social proof settings saved!');
    }
    
    /**
     * Trust Badges settings
     */
    public function trustBadges()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        return view('trust-badges', compact('settings'));
    }
    
    public function updateTrustBadges(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $settings->trust_badges_enabled = $request->boolean('trust_badges_enabled', true);
        $settings->trust_badges_position = $request->input('trust_badges_position', 'below-add-to-cart');
        
        // Badges JSON mein save karna
        $badges = [
            ['id' => 1, 'type' => 'secure-checkout', 'label' => $request->input('badge_secure', 'Secure Checkout'), 'enabled' => $request->boolean('badge_secure_enabled', true), 'icon' => 'secure'],
            ['id' => 2, 'type' => 'fast-delivery', 'label' => $request->input('badge_delivery', 'Fast Delivery'), 'enabled' => $request->boolean('badge_delivery_enabled', true), 'icon' => 'delivery'],
            ['id' => 3, 'type' => 'money-back', 'label' => $request->input('badge_money', 'Money Back Guarantee'), 'enabled' => $request->boolean('badge_money_enabled', true), 'icon' => 'money'],
        ];
        
        $settings->trust_badges = json_encode($badges);
        $settings->save();
        
        return redirect()->route('trust-badges')->with('success', 'Trust badges settings saved!');
    }
    
    /**
     * Urgency settings
     */
    public function urgency()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        return view('urgency', compact('settings'));
    }
    
    public function updateUrgency(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $settings->urgency_enabled = $request->boolean('urgency_enabled', true);
        $settings->timer_enabled = $request->boolean('timer_enabled', true);
        $settings->timer_message = $request->input('timer_message', 'Offer ends in:');
        $settings->stock_urgency_enabled = $request->boolean('stock_urgency_enabled', true);
        $settings->stock_urgency_message = $request->input('stock_urgency_message', 'Only {quantity} left in stock - order soon!');
        $settings->stock_urgency_threshold = $request->input('stock_urgency_threshold', 10);
        
        $settings->save();
        
        return redirect()->route('urgency')->with('success', 'Urgency settings saved!');
    }
    
    /**
     * Product Page settings
     */
    public function productPage()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        return view('product-page', compact('settings'));
    }
    
    public function updateProductPage(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $settings->product_page_enabled = $request->boolean('product_page_enabled', true);
        $settings->feature_icons_enabled = $request->boolean('feature_icons_enabled', true);
        $settings->benefit_bullets_enabled = $request->boolean('benefit_bullets_enabled', true);
        $settings->faq_enabled = $request->boolean('faq_enabled', true);
        $settings->related_products_enabled = $request->boolean('related_products_enabled', true);
        
        $settings->save();
        
        return redirect()->route('product-page')->with('success', 'Product page settings saved!');
    }
}
