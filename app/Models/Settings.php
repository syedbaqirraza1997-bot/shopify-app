<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    
    protected $table = 'settings';
    
    protected $fillable = [
        'shop_domain',
        'primary_color',
        'custom_css',
        'mobile_optimized',
        
        // Sales Popup
        'sales_popup_enabled',
        'sales_popup_position',
        'sales_popup_duration',
        'sales_popup_delay',
        'sales_popup_max',
        'sales_popup_mobile',
        'sales_popup_animation',
        'sales_popup_data_source',
        'sales_popup_template',
        
        // Reviews
        'reviews_enabled',
        'reviews_require_approval',
        'reviews_allow_photos',
        'reviews_allow_videos',
        'reviews_per_page',
        'reviews_show_verified',
        'reviews_star_color',
        
        // Social Proof
        'social_proof_enabled',
        'viewers_enabled',
        'viewers_min',
        'viewers_max',
        'stock_enabled',
        'stock_threshold',
        'trending_enabled',
        'trending_min_orders',
        
        // Trust Badges
        'trust_badges_enabled',
        'trust_badges_position',
        'trust_badges',
        
        // Urgency
        'urgency_enabled',
        'timer_enabled',
        'timer_message',
        'stock_urgency_enabled',
        'stock_urgency_message',
        'stock_urgency_threshold',
        
        // Product Page
        'product_page_enabled',
        'feature_icons_enabled',
        'benefit_bullets_enabled',
        'faq_enabled',
        'related_products_enabled',
    ];
    
    protected $casts = [
        'sales_popup_enabled' => 'boolean',
        'sales_popup_mobile' => 'boolean',
        'reviews_enabled' => 'boolean',
        'reviews_require_approval' => 'boolean',
        'reviews_allow_photos' => 'boolean',
        'reviews_allow_videos' => 'boolean',
        'social_proof_enabled' => 'boolean',
        'viewers_enabled' => 'boolean',
        'stock_enabled' => 'boolean',
        'trending_enabled' => 'boolean',
        'trust_badges_enabled' => 'boolean',
        'urgency_enabled' => 'boolean',
        'timer_enabled' => 'boolean',
        'stock_urgency_enabled' => 'boolean',
        'product_page_enabled' => 'boolean',
        'feature_icons_enabled' => 'boolean',
        'benefit_bullets_enabled' => 'boolean',
        'faq_enabled' => 'boolean',
        'related_products_enabled' => 'boolean',
        'mobile_optimized' => 'boolean',
    ];
}
