<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Shop;
use App\Models\Settings;

class AuthController extends Controller
{
    /**
     * Step 1: Shopify OAuth shuru karna
     */
    public function start(Request $request)
    {
        // Shop domain check karna
        $shop = $request->get('shop');

        if (!$shop) {
            return 'Error: Shop domain required. URL mein ?shop=yourstore.myshopify.com add karein';
        }

        // Validate shop domain format
        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-]*\.myshopify\.com$/', $shop)) {
            return 'Error: Invalid shop domain format';
        }

        // Nonce generate karna (security ke liye)
        $nonce = bin2hex(random_bytes(16));
        Session::put('oauth_state', $nonce);
        Session::put('shop_domain', $shop);

        // Shopify OAuth URL banana
        $apiKey = env('SHOPIFY_API_KEY');
        $scopes = 'read_products,write_products,read_orders,write_orders,read_content,write_content,read_themes,write_themes,read_customers,write_customers';
        $redirectUri = env('SHOPIFY_APP_URL') . '/auth/callback';

        $authUrl = "https://{$shop}/admin/oauth/authorize?" . http_build_query([
            'client_id' => $apiKey,
            'scope' => $scopes,
            'redirect_uri' => $redirectUri,
            'state' => $nonce,
        ]);

        // Shopify ke permission page par bhejna
        return redirect($authUrl);
    }

    /**
     * Step 2: Shopify se wapas aana (callback)
     */
    public function callback(Request $request)
    {
        $shop = $request->get('shop');
        $code = $request->get('code');
        $state = $request->get('state');

        // State verify karna (CSRF protection)
        if ($state !== Session::get('oauth_state')) {
            return 'Error: Invalid state parameter. Security check failed.';
        }

        // Session clear karna
        Session::forget('oauth_state');

        if (!$code) {
            return 'Error: Authorization code missing';
        }

        // Step 3: Access token lena Shopify se
        $apiKey = env('SHOPIFY_API_KEY');
        $apiSecret = env('SHOPIFY_API_SECRET');

        $tokenUrl = "https://{$shop}/admin/oauth/access_token";

        $response = Http::post($tokenUrl, [
            'client_id' => $apiKey,
            'client_secret' => $apiSecret,
            'code' => $code,
        ]);

        if (!$response->successful()) {
            return 'Error: Failed to get access token. ' . $response->body();
        }

        $accessToken = $response->json('access_token');

        // Step 4: Shop ki information lena
        $shopInfoUrl = "https://{$shop}/admin/api/2024-01/shop.json";

        $shopResponse = Http::withHeaders([
            'X-Shopify-Access-Token' => $accessToken,
        ])->get($shopInfoUrl);

        $shopData = $shopResponse->json('shop');

        // Step 5: Database mein shop save karna
        $shopModel = Shop::updateOrCreate(
            ['shop_domain' => $shop],
            [
                'access_token' => $accessToken,
                'shop_name' => $shopData['name'] ?? '',
                'shop_email' => $shopData['email'] ?? '',
                'shop_country' => $shopData['country_name'] ?? '',
                'shop_currency' => $shopData['currency'] ?? '',
                'is_active' => true,
            ]
        );

        // Step 6: Default settings create karna
        Settings::firstOrCreate(
            ['shop_domain' => $shop],
            [
                'sales_popup_enabled' => true,
                'sales_popup_position' => 'bottom-left',
                'reviews_enabled' => true,
                'social_proof_enabled' => true,
                'trust_badges_enabled' => true,
                'urgency_enabled' => true,
            ]
        );

        // Step 7: Session mein shop save karna
        Session::put('shop_domain', $shop);
        Session::put('access_token', $accessToken);

        // Dashboard par redirect karna
        return redirect()->route('dashboard');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Session::forget('shop_domain');
        Session::forget('access_token');

        return redirect('/')->with('message', 'Successfully logged out');
    }
}
