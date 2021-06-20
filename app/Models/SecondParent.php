<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondParent extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name', 'middle_name', 'last_name', 'phoneNumber'
    ];

    public $timestamps = true;

    public function parents()
    {
        return $this->hasOne(Parents::class, 'second_parent_id', 'id');

    }
}
