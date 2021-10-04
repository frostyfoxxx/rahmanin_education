<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Appraisal extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = true;
    public $fillable = [
        'subject', 'appraisal', 'user_id'
    ];

    public static $logAttributes = [
        'subject', 'appraisal'
    ];

    public static $logName = 'Предметы и оценки ';

    /**
     * @return BelongsTo
     */
    public function appraisal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
