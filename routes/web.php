<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\ImportController;
use App\Http\Middleware\AuthShop;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Yeh file mein saari website URLs define hoti hain
|
*/

// Home / Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// ============================================
// SHOPIFY AUTHENTICATION ROUTES
// ============================================

// Step 1: App install karna (Shopify se permission lena)
Route::get('/auth', [AuthController::class, 'start'])->name('auth.start');

// Step 2: Shopify se wapas aana (callback)
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ============================================
// ADMIN DASHBOARD ROUTES (Login ke baad)
// ============================================

// Middleware 'auth.shop' check karega ke user login hai ya nahi
Route::middleware([AuthShop::class])->group(function () {

    // Dashboard - Main page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/{id}/delete', [ReviewController::class, 'delete'])->name('reviews.delete');
    Route::post('/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

    // Sales Popups
    Route::get('/popups', [PopupController::class, 'index'])->name('popups');
    Route::post('/popups/settings', [PopupController::class, 'updateSettings'])->name('popups.settings');
    Route::post('/popups/generate', [PopupController::class, 'generateSimulated'])->name('popups.generate');

    // Social Proof
    Route::get('/social-proof', [SettingsController::class, 'socialProof'])->name('social-proof');
    Route::post('/social-proof', [SettingsController::class, 'updateSocialProof'])->name('social-proof.update');

    // Trust Badges
    Route::get('/trust-badges', [SettingsController::class, 'trustBadges'])->name('trust-badges');
    Route::post('/trust-badges', [SettingsController::class, 'updateTrustBadges'])->name('trust-badges.update');

    // Urgency
    Route::get('/urgency', [SettingsController::class, 'urgency'])->name('urgency');
    Route::post('/urgency', [SettingsController::class, 'updateUrgency'])->name('urgency.update');

    // Product Page
    Route::get('/product-page', [SettingsController::class, 'productPage'])->name('product-page');
    Route::post('/product-page', [SettingsController::class, 'updateProductPage'])->name('product-page.update');

    // Import
    Route::get('/import', [ImportController::class, 'index'])->name('import');
    Route::post('/import/csv', [ImportController::class, 'importCSV'])->name('import.csv');

    // Analytics
    Route::get('/analytics/data', [AnalyticsController::class, 'getData'])->name('analytics.data');
});

// ============================================
// PUBLIC WIDGET ROUTES (Koi bhi access kar sakta hai)
// ============================================

Route::get('/widgets/config', [WidgetController::class, 'config'])->name('widgets.config');
Route::get('/widgets/reviews', [WidgetController::class, 'getReviews'])->name('widgets.reviews');
Route::post('/widgets/reviews', [WidgetController::class, 'submitReview'])->name('widgets.reviews.submit');
Route::get('/widgets/popups', [WidgetController::class, 'getPopups'])->name('widgets.popups');
Route::post('/widgets/track', [WidgetController::class, 'trackEvent'])->name('widgets.track');

// Widget JavaScript files
Route::get('/widgets/script.js', [WidgetController::class, 'script'])->name('widgets.script');
Route::get('/widgets/styles.css', [WidgetController::class, 'styles'])->name('widgets.styles');
