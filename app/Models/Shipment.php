<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'vessel_name',
        'eta',
        'etd',
    ];

    protected $casts = [
        'eta' => 'date: mm-dd-yyyy',
        'etd' => 'date: mm-dd-yyyy',
    ];

    public function stocks(): BelongsTo
    {
        return $this->belongsTo(Stocks::class);
    }
}
