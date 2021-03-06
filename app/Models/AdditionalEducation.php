<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdditionalEducation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'form_of_education',
        'name_of_educational_institution',
        'number_of_diploma',
        'year_of_ending',
        'qualification',
        'specialty',
        'user_id',
    ];

    protected $table = 'additional_educations';

    public static $logName ='Дополнительное образование';
    public static $logAttributes = [
        'form_of_education',
        'name_of_educational_institution',
        'number_of_diploma',
        'year_of_ending',
        'qualification',
        'specialty'
    ];
}
