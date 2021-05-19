<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passport extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $fillable = [
        'series', 'number', 'date_of_issue', 'issued_by', 'date_of_birth',
        'male', 'place_of_birth', 'registration_address', 'lack_of_citizenship'
        , 'user_id'
    ];

    protected $table = 'passport';


    public function passport():BelongsTo
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
}
