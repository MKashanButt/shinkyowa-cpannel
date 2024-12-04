<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTUploaded extends Model
{
    use HasFactory;

    protected $table = 'tt-uploaded';

    protected $fillabble = [
        'stock_id',
        'customer_email',
        'in_usd',
        'in_yen',
        'payment_date',
        'description',
        'agent',
        'viewed'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];
}
