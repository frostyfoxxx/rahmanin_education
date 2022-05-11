<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserQualification extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'qualification_id', 'middlemark', 'form_education', 'type_education'
    ];

    public static $logName ='Выбраная пользователем класификация ';
    public static $logAttributes = ['user_id', 'qualification_id', 'average_score_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getQualification()
    {
        return $this->hasMany(Qualification::class, 'qualification_id', 'id');
    }
}
