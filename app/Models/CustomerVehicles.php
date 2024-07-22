<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'vehicle',
        'customer_email',
        'status',
    ];
}
