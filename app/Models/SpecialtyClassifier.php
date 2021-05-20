<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtyClassifier extends Model
{
    use HasFactory;
    protected $table = 'specialty_classifier';

    protected $fillable = [
      'code', 'specialty'
    ];

    public function qualifications()
    {
        return $this->hasMany(QualificationClassifier::class, 'specialty_id', 'id');
    }
}
