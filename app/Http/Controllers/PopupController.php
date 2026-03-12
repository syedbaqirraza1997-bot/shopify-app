<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Settings;
use App\Models\Popup;

class PopupController extends Controller
{
    /**
     * Popups page dikhana
     */
    public function index()
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $popups = Popup::where('shop_domain', $shopDomain)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        
        return view('popups', compact('settings', 'popups'));
    }
    
    /**
     * Popup settings update karna
     */
    public function updateSettings(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $settings = Settings::where('shop_domain', $shopDomain)->first();
        
        $settings->sales_popup_enabled = $request->boolean('sales_popup_enabled', true);
        $settings->sales_popup_position = $request->input('sales_popup_position', 'bottom-left');
        $settings->sales_popup_duration = $request->input('sales_popup_duration', 5000);
        $settings->sales_popup_delay = $request->input('sales_popup_delay', 10000);
        $settings->sales_popup_max = $request->input('sales_popup_max', 5);
        $settings->sales_popup_mobile = $request->boolean('sales_popup_mobile', true);
        $settings->sales_popup_animation = $request->input('sales_popup_animation', 'slide');
        $settings->sales_popup_data_source = $request->input('sales_popup_data_source', 'real');
        $settings->sales_popup_template = $request->input('sales_popup_template', '{{name}} from {{location}} purchased {{product}}');
        
        $settings->save();
        
        return redirect()->route('popups')->with('success', 'Popup settings saved!');
    }
    
    /**
     * Simulated popup generate karna
     */
    public function generateSimulated()
    {
        $shopDomain = Session::get('shop_domain');
        
        $names = ['Ahmed', 'Sarah', 'John', 'Emma', 'Michael', 'Lisa', 'David', 'Anna'];
        $locations = ['Dubai', 'London', 'New York', 'Toronto', 'Sydney', 'Singapore', 'Berlin', 'Paris'];
        $products = ['Premium Headphones', 'Smart Watch', 'Leather Bag', 'Wireless Charger'];
        
        $popup = new Popup();
        $popup->shop_domain = $shopDomain;
        $popup->source = 'simulated';
        $popup->customer_name = $names[array_rand($names)];
        $popup->customer_location = $locations[array_rand($locations)];
        $popup->product_name = $products[array_rand($products)];
        $popup->product_id = 'simulated_' . time();
        $popup->order_value = rand(20, 200);
        $popup->time_ago = rand(2, 60) . ' minutes ago';
        $popup->is_simulated = true;
        $popup->save();
        
        return redirect()->route('popups')->with('success', 'Test popup generated!');
    }
}
