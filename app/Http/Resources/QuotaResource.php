<?php

namespace App\Http\Resources;

use App\Models\SpecialtyClassifier;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "code" => SpecialtyClassifier::find($this->getQualificationClassifier->specialty_id)->code,
            "specialty" => SpecialtyClassifier::find($this->getQualificationClassifier->specialty_id)->specialty,
            "qualification" => $this->getQualificationClassifier->qualification,
            'full_time' => ($this->ft_budget_quota == 0) ? false : true,
            "remote" => ($this->rm_budget_quota == 0) ? false : true,
            "ft_budget_quota" => $this->ft_budget_quota,
            "rm_budget_quota" => $this->rm_budget_quota,
            "working_profession" => ($this->working_profession == 0) ? false : true,
            "budget" => ($this->budget == 0) ? false : true,
            "commercial" => ($this->commercial == 0) ? false : true,
        ];
    }
}
