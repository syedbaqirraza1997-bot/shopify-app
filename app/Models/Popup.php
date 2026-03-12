<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;
    
    protected $table = 'popups';
    
    protected $fillable = [
        'shop_domain',
        'source',
        'order_id',
        'customer_name',
        'customer_location',
        'product_id',
        'product_name',
        'product_image',
        'order_value',
        'time_ago',
        'is_simulated',
        'is_active',
        'display_count',
        'last_displayed_at',
    ];
    
    protected $casts = [
        'is_simulated' => 'boolean',
        'is_active' => 'boolean',
        'order_value' => 'decimal:2',
        'display_count' => 'integer',
        'last_displayed_at' => 'datetime',
    ];
}
