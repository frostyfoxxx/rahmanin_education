<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            "first_name" => $this->PersonalData->first_name,
            "middle_name" => $this->PersonalData->middle_name,
            "last_name" => $this->PersonalData->last_name,
            "middlemark" => $this->School->middlemark,
            "data_confirmed" => $this->data_confirmed,
        ];
    }
}
