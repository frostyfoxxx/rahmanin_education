<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    protected $fillable = [
        'series',
        'number',
        'date_of_issue',
        'issued_by',
        'date_of_birth',
        'male',
        'place_of_birth',
        'address_of_birth',
        'lack_of_citizenship',
    ];
}
