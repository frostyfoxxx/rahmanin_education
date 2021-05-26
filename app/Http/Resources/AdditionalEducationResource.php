<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalEducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'form_of_education'=>$this->form_of_education,
            'name_of_educational_institution'=>$this->name_of_educational_institution,
            'number_of_diploma'=>$this->number_of_diploma,
            'year_of_ending'=>$this->year_of_ending,
            'qualification'=>$this->qualification,
            'specialty'=>$this->specialty,
        ];
    }
}
