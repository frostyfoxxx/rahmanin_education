<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'qualification_classifier_id',
        'ft_budget_quota',
        'rm_budget_quota',
        'working_profession',
        'rm_commercial',
        'ft_commercial'
    ];

    /**
     * @return BelongsTo
     */
    public function getQualificationClassifier():BelongsTo
    {
        return $this->belongsTo(QualificationClassifier::class,'qualification_classifier_id', 'id');
    }
}
