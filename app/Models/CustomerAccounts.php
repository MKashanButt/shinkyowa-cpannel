<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_company',
        'customer_phone',
        'description',
        'buying',
        'deposit',
        'remaining',
        'agent_manager',
        'agent_id',
        'customer_email',
        'currency',
    ];
}
