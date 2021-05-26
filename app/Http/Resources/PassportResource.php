<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
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
            'series'=>$this->series,
            'number'=>$this->number,
            'date_of_issue'=>$this->date_of_issue,
            'issued_by'=>$this->issued_by,
            'date_of_birth'=>$this->date_of_birth,
            'male'=>$this->male,
            'place_of_birth'=>$this->place_of_birth,
            'address_of_birth'=>$this->address_of_birth,
            'lack_of_citizenship'=>$this->lack_of_citizenship,
        ];
    }
}
