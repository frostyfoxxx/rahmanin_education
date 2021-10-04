<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SecondParent extends Model
{
    use HasFactory, LogsActivity;

    public $fillable = [
        'first_name', 'middle_name', 'last_name', 'phoneNumber'
    ];

    public $timestamps = true;

    public static $logAttributes=[
        'first_name', 'middle_name', 'last_name', 'phone_number'
    ];

    public static $logName ='Второй родитель пользователя';

    public function parents()
    {
        return $this->hasOne(Parents::class, 'second_parent_id', 'id');
    }
}
