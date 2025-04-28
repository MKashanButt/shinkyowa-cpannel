<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'stock_images'
    ];

    protected $casts = [
        'stock_images' => 'array',
        'features' => 'array',
    ];

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
