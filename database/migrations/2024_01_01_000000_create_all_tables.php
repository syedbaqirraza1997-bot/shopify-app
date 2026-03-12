<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Shops table
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            // shortened shop_domain to avoid MySQL index key length limits
            $table->string('shop_domain', 100)->unique();
            $table->text('access_token');
            $table->string('shop_name', 191)->nullable();
            $table->string('shop_email', 191)->nullable();
            $table->string('shop_country', 191)->nullable();
            $table->string('shop_currency', 191)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Settings table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // shortened shop_domain to avoid index key length issues
            $table->string('shop_domain', 100)->unique();

            // General
            $table->string('primary_color', 191)->default('#008060');
            $table->text('custom_css')->nullable();
            $table->boolean('mobile_optimized')->default(true);

            // Sales Popup
            $table->boolean('sales_popup_enabled')->default(true);
            $table->string('sales_popup_position', 191)->default('bottom-left');
            $table->integer('sales_popup_duration')->default(5000);
            $table->integer('sales_popup_delay')->default(10000);
            $table->integer('sales_popup_max')->default(5);
            $table->boolean('sales_popup_mobile')->default(true);
            $table->string('sales_popup_animation', 191)->default('slide');
            $table->string('sales_popup_data_source', 191)->default('real');
            $table->string('sales_popup_template', 191)->default('{{name}} from {{location}} purchased {{product}}');

            // Reviews
            $table->boolean('reviews_enabled')->default(true);
            $table->boolean('reviews_require_approval')->default(true);
            $table->boolean('reviews_allow_photos')->default(true);
            $table->boolean('reviews_allow_videos')->default(true);
            $table->integer('reviews_per_page')->default(10);
            $table->boolean('reviews_show_verified')->default(true);
            $table->string('reviews_star_color', 191)->default('#ffc107');

            // Social Proof
            $table->boolean('social_proof_enabled')->default(true);
            $table->boolean('viewers_enabled')->default(true);
            $table->integer('viewers_min')->default(5);
            $table->integer('viewers_max')->default(50);
            $table->boolean('stock_enabled')->default(true);
            $table->integer('stock_threshold')->default(10);
            $table->boolean('trending_enabled')->default(true);
            $table->integer('trending_min_orders')->default(10);

            // Trust Badges
            $table->boolean('trust_badges_enabled')->default(true);
            $table->string('trust_badges_position', 191)->default('below-add-to-cart');
            $table->json('trust_badges')->nullable();

            // Urgency
            $table->boolean('urgency_enabled')->default(true);
            $table->boolean('timer_enabled')->default(true);
            $table->string('timer_message', 191)->default('Offer ends in:');
            $table->boolean('stock_urgency_enabled')->default(true);
            $table->string('stock_urgency_message', 191)->default('Only {quantity} left in stock - order soon!');
            $table->integer('stock_urgency_threshold')->default(10);

            // Product Page
            $table->boolean('product_page_enabled')->default(true);
            $table->boolean('feature_icons_enabled')->default(true);
            $table->boolean('benefit_bullets_enabled')->default(true);
            $table->boolean('faq_enabled')->default(true);
            $table->boolean('related_products_enabled')->default(true);

            $table->timestamps();
        });

        // Reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // shorten indexed columns to avoid MySQL max key length errors
            $table->string('shop_domain', 100);
            $table->string('product_id', 100);
            $table->string('product_title', 191);
            $table->integer('rating')->default(5);
            $table->string('title', 191)->nullable();
            $table->text('content');
            $table->string('customer_name', 191);
            $table->string('customer_email', 191)->nullable();
            $table->string('customer_id', 191)->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->json('photos')->nullable();
            $table->json('videos')->nullable();
            $table->integer('helpful_count')->default(0);
            $table->text('reply_content')->nullable();
            $table->timestamp('reply_date')->nullable();
            // shorten status because it is included in an index
            $table->string('status', 50)->default('pending'); // pending, approved, rejected
            $table->string('imported_from', 191)->nullable(); // manual, csv, aliexpress, amazon
            $table->string('ip_address', 191)->nullable();
            $table->timestamps();

            $table->index(['shop_domain', 'product_id']);
            $table->index(['shop_domain', 'status']);
        });

        // Popups table
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            // shortened shop_domain for indexing
            $table->string('shop_domain', 100);
            $table->string('source', 191)->default('real'); // real, simulated
            $table->string('order_id', 191)->nullable();
            $table->string('customer_name', 191);
            $table->string('customer_location', 191)->nullable();
            $table->string('product_id', 100);
            $table->string('product_name', 191);
            $table->string('product_image', 191)->nullable();
            $table->decimal('order_value', 10, 2)->nullable();
            $table->string('time_ago', 191)->nullable();
            $table->boolean('is_simulated')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_count')->default(0);
            $table->timestamp('last_displayed_at')->nullable();
            $table->timestamps();

            $table->index(['shop_domain', 'is_active']);
        });

        // Analytics table
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            // shorten indexed strings to avoid key length limits
            $table->string('shop_domain', 100);
            $table->string('event_type', 100);
            $table->string('category', 191)->default('general');
            $table->string('product_id', 100)->nullable();
            $table->string('review_id', 191)->nullable();
            $table->string('popup_id', 191)->nullable();
            $table->string('session_id', 191)->nullable();
            $table->string('page_url', 191)->nullable();
            $table->string('visitor_id', 191)->nullable();
            $table->json('metadata')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->string('ip_address', 191)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['shop_domain', 'event_type']);
            $table->index(['shop_domain', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
        Schema::dropIfExists('popups');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('shops');
    }
};
