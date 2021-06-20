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
            'full_time' => ($this->ft_budget_quota == 0 || $this->ft_commercial == 0) ? false : true, // Очная
            "remote" => ($this->rm_budget_quota == 0 || $this->rm_commercial == 0) ? false : true, // Заочная
            "ft_budget_quota" => $this->ft_budget_quota, // Бюджетных мест на очно
            "rm_budget_quota" => $this->rm_budget_quota, // Бюджетных мест на заочно
            "ft_budget" => ($this->ft_budget_quota == 0) ? false : true,
            "rm_budget" =>($this->rm_budget_quota == 0) ? false : true,
            'ft_commercial' => ($this->ft_commercial == 1) ? true : false,
            "rm_commercial" => ($this->rm_commercial == 1) ? true : false,
            "working_profession" => ($this->working_profession == 0) ? false : true, // Рабочая профеесия
        ];
    }
}
