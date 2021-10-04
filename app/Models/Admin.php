<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Admin extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'user_id'
    ];

    public $timestamps = false;
    public static $logAttributes =[
        'first_name', 'middle_name', 'last_name',
    ];
    public static $logName ='Данные администраторов';
}
