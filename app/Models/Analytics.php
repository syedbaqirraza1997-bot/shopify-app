<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;
    
    protected $table = 'analytics';
    
    protected $fillable = [
        'shop_domain',
        'event_type',
        'category',
        'product_id',
        'review_id',
        'popup_id',
        'session_id',
        'page_url',
        'visitor_id',
        'metadata',
        'value',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'value' => 'decimal:2',
    ];
}
