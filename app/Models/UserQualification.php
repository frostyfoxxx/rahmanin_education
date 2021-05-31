<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQualification extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'qualification_id', 'middlemark', 'form_education', 'type_education'
    ];
}
