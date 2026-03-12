<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    
    protected $table = 'shops';
    
    protected $fillable = [
        'shop_domain',
        'access_token',
        'shop_name',
        'shop_email',
        'shop_country',
        'shop_currency',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
