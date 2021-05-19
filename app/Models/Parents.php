<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_parent',
        'secon_parent_id',

    ];
    public function User()
    {
      return $this->belongsTo(User::class);
    }
    public function FirstParent()
    {
        return $this->belongsTo(FirstParent::class);
    }
    public function SecondParent()
    {
        return $this->belongsTo(SecondParent::class);
    }
}
