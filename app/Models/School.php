<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class School extends Model
{
  use HasFactory, LogsActivity;

  protected $fillable = [
    'school_name',
    'number_of_classes',
    'year_of_ending',
    'number_of_certificate',
    'number_of_photo',
    'version_of_the_certificate',
    'middlemark',
    'user_id'
  ];

  public static $logAttributes = [
    'school_name',
    'number_of_classes',
    'year_of_ending',
    'number_of_certificate',
    'number_of_photo',
    'version_of_the_certificate'
  ];
public static $logName ='Школьные данные';
  public function User()
  {
    return $this->belongsTo(User::class);
  }
}
