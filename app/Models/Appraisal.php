<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appraisal extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $fillable = [
        'subject', 'appraisal', 'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function appraisal():BelongsTo
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
}
