<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RecordingDate extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'recordingdates';
    protected $fillable = ['id', 'date_recording'];
    
    public static $logAttributes = [
        'date_recording'
    ];

    public static $logName ='Дата подтверждения';

    public function getTime()
    {
        return $this->hasMany(RecordingTime::class, 'daterecording_id', 'id');
    }
}
