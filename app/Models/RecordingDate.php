<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingDate extends Model
{
    use HasFactory;

    protected $table = 'recordingdates';
    protected $fillable = ['id', 'date_recording'];

    public function getTime()
    {
        return $this->hasMany(RecordingTime::class, 'daterecording_id', 'id');
    }
}
