<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_of_education',
        'name_of_educational_institution',
        'number_of_diploma',
        'year_of_ending',
        'qualification',
        'specialty',
    ];
}
