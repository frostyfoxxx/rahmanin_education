<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FirstParent extends Model
{
    use HasFactory, LogsActivity;


    public $timestamps = true;
    public $fillable = [
        'first_name', 'middle_name', 'last_name', 'phoneNumber'
    ];

    public static $logAttributes=[
        'first_name', 'middle_name', 'last_name', 'phone_number'
    ];

    public static $logName ='Первые родитель пользователя ';

    public function parents()
    {
        return $this->hasOne(Parents::class, 'first_parent_id', 'id');

    }

}
