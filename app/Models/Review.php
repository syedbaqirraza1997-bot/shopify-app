<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $table = 'reviews';
    
    protected $fillable = [
        'shop_domain',
        'product_id',
        'product_title',
        'rating',
        'title',
        'content',
        'customer_name',
        'customer_email',
        'customer_id',
        'is_verified_purchase',
        'photos',
        'videos',
        'helpful_count',
        'reply_content',
        'reply_date',
        'status',
        'imported_from',
        'ip_address',
    ];
    
    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'helpful_count' => 'integer',
        'reply_date' => 'datetime',
        'photos' => 'array',
        'videos' => 'array',
    ];
}
