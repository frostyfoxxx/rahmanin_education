<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SpecialtyClassifier extends Model
{
  use HasFactory, LogsActivity;

  protected $table = 'specialty_classifiers';

  protected $fillable = [
    'code', 'specialty'
  ];

  public static $logAttributes = ['code', 'specialty'];
  public static $logName = 'Классификатор специальностей';

  public function qualifications()
  {
    return $this->hasMany(QualificationClassifier::class, 'specialty_id', 'id');
  }
}
