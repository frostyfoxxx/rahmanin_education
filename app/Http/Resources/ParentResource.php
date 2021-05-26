<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            [
                'first_name' => $this->first_parent->first_name,
                'middle_name' => $this->first_parent->middle_name,
                'last_name' => $this->first_parent->last_name,
                'phone' => $this->first_parent->phoneNumber
            ],
            [
                'first_name' => $this->second_parent->first_name,
                'middle_name' => $this->second_parent->middle_name,
                'last_name' => $this->second_parent->last_name,
                'phone' => $this->second_parent->phoneNumber
            ]


        ];
    }
}
