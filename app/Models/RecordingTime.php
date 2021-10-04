<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RecordingTime extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'recordingtime';
    protected $fillable = [
        'daterecording_id',
        'recording_start',
        'recording_ends',
        'user_id',

    ];

    public static $logAttributes = [
        'daterecording_id',
        'recording_start',
        'recording_ends',
        'user_id',
    ];

    public static $logName ='Запись на подтверждение';

    public function getDate()
    {
        return $this->belongsTo(RecordingDate::class, 'daterecording_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
