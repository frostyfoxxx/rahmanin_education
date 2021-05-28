<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationClassifier extends Model
{
    use HasFactory;

    protected $table = 'qualification_classifiers';

    protected $fillable = [
        'specialty_id', 'qualification'
    ];


    public function getSpecialty()
    {
        return $this->belongsTo(SpecialtyClassifier::class, 'specialty_id', 'id');
    }

    public function qualification()
    {
        return $this->hasOne(Qualification::class, 'qualification_classifier_id', 'id');
    }
}
