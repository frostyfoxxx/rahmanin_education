<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstParent extends Model
{
    use HasFactory;


    public $timestamps = true;
    public $fillable = [
        'first_name', 'middle_name', 'last_name', 'phoneNumber'
    ];

}
