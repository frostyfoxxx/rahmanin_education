<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondParent extends Model
{
    use HasFactory;
    public  $table = 'second_parent';

    public $fillable = [
        'first_name', 'middle_name', 'last_name', 'phoneNumber'
    ];

    public $timestamps = true;
}
