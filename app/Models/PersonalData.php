<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class PersonalData extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'orphan',
        'phone',
        'childhood_disabled',
        'the_large_family',
        'hostel_for_students',
        'user_id'
    ];

    public static $logAttributes = [
        'first_name',
        'middle_name',
        'last_name',
        'orphan',
        'phone',
        'childhood_disabled',
        'the_large_family',
        'hostel_for_students'
    ];

    public static $logName ='Персональные данные';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
