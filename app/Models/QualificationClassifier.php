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

    public function getSpecialty()
    {
        $this->hasMany(SpecialtyClassifier::class, 'id', 'specialty_id');
    }
}
