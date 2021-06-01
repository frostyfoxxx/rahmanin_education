<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingTime extends Model
{
    use HasFactory;

    protected $table = 'recordingtime';
    protected $fillable = [
        'daterecording_id',
        'recording_start',
        'recording_ends',
        'user_id',

    ];

    public function getDate()
    {
        return $this->belongsTo(RecordingDate::class, 'daterecording_id');
    }
}
