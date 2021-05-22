<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'qualification_classifier_id',
        'ft_budget_quota',
        'rm_budget_quota',
        'working_profession',
        'budget',
        'commercial'
    ];

    public function getQualificationClassifier()
    {
        return $this->hasOne(QualificationClassifier::class, 'id', 'qualification_classifier_id');
    }
}
