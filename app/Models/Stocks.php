<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'stock_id',
        'chassis',
        'make',
        'model',
        'year',
        'fob',
        'currency',
        'mileage',
        'doors',
        'transmission',
        'body_type',
        'fuel',
        'category',
        'country',
        'features',
        'thumbnail',
        'stock_images'
    ];

    protected $casts = [
        'stock_images' => 'array',
        'features' => 'array',
    ];
}
