<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberOfSeatsResource extends JsonResource
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
            'number_of_budget_seats'=>$this->number_of_budget_seats,
            'number_of_places_of_commerce'=>$this->number_of_places_of_commerce,
        ];
    }
}
