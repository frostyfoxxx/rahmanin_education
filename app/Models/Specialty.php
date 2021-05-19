<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'specialty',
    ];
    public function qualification()
    {
      return $this->hasMany(qualification::class);
    }
}
