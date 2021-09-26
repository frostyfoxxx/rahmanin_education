<?php

namespace App\Http\Resources;

use App\Models\Qualification;
use App\Models\QualificationClassifier;
use App\Models\SpecialtyClassifier;
use Illuminate\Http\Resources\Json\JsonResource;

class ChosenSpecialtyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'specialty' => SpecialtyClassifier::find(QualificationClassifier::find(Qualification::find($this->qualification_id)->qualification_classifier_id)->specialty_id)->specialty,
            'qualification' => QualificationClassifier::find(Qualification::find($this->qualification_id)->qualification_classifier_id)->qualification,
            'average_score_invite' => Qualification::find($this->qualification_id)->average_score_invite,

        ];
    }
}
