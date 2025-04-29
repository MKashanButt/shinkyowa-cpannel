<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextPassword extends Model
{
    use HasFactory;

    protected $table = 'text_password';

    protected $fillable = [
        'email',
        'password',
    ];
}
