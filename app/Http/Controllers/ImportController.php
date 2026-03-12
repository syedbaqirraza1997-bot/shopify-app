<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Review;

class ImportController extends Controller
{
    /**
     * Import page dikhana
     */
    public function index()
    {
        return view('import');
    }
    
    /**
     * CSV se reviews import karna
     */
    public function importCSV(Request $request)
    {
        $shopDomain = Session::get('shop_domain');
        
        if (!$request->hasFile('csv_file')) {
            return redirect()->route('import')->with('error', 'Please select a CSV file');
        }
        
        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Header row read karna
        $headers = fgetcsv($handle);
        
        $imported = 0;
        $errors = [];
        
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($headers, $row);
            
            try {
                $review = new Review();
                $review->shop_domain = $shopDomain;
                $review->product_id = $data['product_id'] ?? 'unknown';
                $review->product_title = $data['product_title'] ?? 'Unknown Product';
                $review->rating = intval($data['rating'] ?? 5);
                $review->title = $data['title'] ?? '';
                $review->content = $data['content'] ?? $data['review'] ?? '';
                $review->customer_name = $data['name'] ?? $data['customer_name'] ?? 'Anonymous';
                $review->customer_email = $data['email'] ?? 'anonymous@example.com';
                $review->status = 'approved';
                $review->imported_from = 'csv';
                $review->save();
                
                $imported++;
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
        
        fclose($handle);
        
        $message = "Imported {$imported} reviews successfully!";
        if (count($errors) > 0) {
            $message .= " (" . count($errors) . " errors)";
        }
        
        return redirect()->route('import')->with('success', $message);
    }
}
