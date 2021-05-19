<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parents extends Model
{
    use HasFactory;

    public $table = 'parent';

    protected $fillable = [
        'user_id',
        'first_parent_id',
        'second_parent_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function first_parent()
    {
        return $this->hasOne(FirstParent::class, 'id', 'first_parent_id');
    }

    public function second_parent()
    {
        return $this->hasOne(SecondParent::class, 'id', 'second_parent_id');
    }

    public $timestamps = false;
}
