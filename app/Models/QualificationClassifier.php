<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationClassifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialty_id', 'qualification'
    ];

    protected $table = 'qualification_classifier';

    public function getSpecialty()
    {
        return $this->belongsTo(SpecialtyClassifier::class, 'specialty_id', 'id');
    }
}
