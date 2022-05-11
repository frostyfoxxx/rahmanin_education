<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Passport extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = true;
    public $fillable = [
        'series', 'number', 'date_of_issue', 'issued_by', 'date_of_birth',
        'gender', 'place_of_birth', 'registration_address', 'lack_of_citizenship', 'user_id'
    ];

    public static $logAttributes = [
        'series', 'number', 'date_of_issue', 'issued_by', 'date_of_birth',
        'gender', 'place_of_birth', 'registration_address', 'lack_of_citizenship'
    ];
    public static $logName = 'Паспортные данные ';

    public function passport(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
