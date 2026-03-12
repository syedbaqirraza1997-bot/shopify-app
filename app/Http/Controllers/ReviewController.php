<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Reviews list dikhana
     */
    public function index(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        $status = $request->get('status', 'all');
        
        $query = Review::where('shop_domain', $shopDomain);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $reviews = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $stats = [
            'total' => Review::where('shop_domain', $shopDomain)->count(),
            'pending' => Review::where('shop_domain', $shopDomain)->where('status', 'pending')->count(),
            'approved' => Review::where('shop_domain', $shopDomain)->where('status', 'approved')->count(),
            'rejected' => Review::where('shop_domain', $shopDomain)->where('status', 'rejected')->count(),
        ];
        
        return view('reviews', compact('reviews', 'stats', 'status'));
    }
    
    /**
     * Review approve karna
     */
    public function approve($id)
    {
        $shopDomain = Session::get('shop_domain');
        
        $review = Review::where('shop_domain', $shopDomain)->findOrFail($id);
        $review->status = 'approved';
        $review->save();
        
        return redirect()->route('reviews')->with('success', 'Review approved successfully!');
    }
    
    /**
     * Review reject karna
     */
    public function reject($id)
    {
        $shopDomain = Session::get('shop_domain');
        
        $review = Review::where('shop_domain', $shopDomain)->findOrFail($id);
        $review->status = 'rejected';
        $review->save();
        
        return redirect()->route('reviews')->with('success', 'Review rejected!');
    }
    
    /**
     * Review delete karna
     */
    public function delete($id)
    {
        $shopDomain = Session::get('shop_domain');
        
        $review = Review::where('shop_domain', $shopDomain)->findOrFail($id);
        $review->delete();
        
        return redirect()->route('reviews')->with('success', 'Review deleted successfully!');
    }
    
    /**
     * Admin reply add karna
     */
    public function reply(Request $request, $id)
    {
        $shopDomain = Session::get('shop_domain');
        
        $review = Review::where('shop_domain', $shopDomain)->findOrFail($id);
        $review->reply_content = $request->input('reply');
        $review->reply_date = now();
        $review->save();
        
        return redirect()->route('reviews')->with('success', 'Reply added successfully!');
    }
}
