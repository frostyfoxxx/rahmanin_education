<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Specialty extends Model
{
  use HasFactory, LogsActivity;

  protected $fillable = [
    'code',
    'specialty',
  ];

  public static $logAttributes = [
    'code', 'specialty'
  ];
  public static $logName = 'Специальности';

  public function qualification()
  {
    return $this->hasMany(qualification::class);
  }
}
