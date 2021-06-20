<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parents extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'first_parent_id',
        'second_parent_id'
    ];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function firstParent()
    {
        return $this->belongsTo(FirstParent::class, 'first_parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function secondParent()
    {
        return $this->belongsTo(SecondParent::class, 'second_parent_id');
    }

    public $timestamps = false;
}
