<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docs extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'japanese_export',
        'english_export',
        'final_invoice',
        'inspection_certificate',
        'bl_copy'
    ];
}
