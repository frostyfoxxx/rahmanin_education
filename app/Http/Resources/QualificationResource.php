<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QualificationResource extends JsonResource
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
            'qualification'=>$this->qualification,
            'distance_learning'=>$this->distance_learning,
            'full_time_education'=>$this->full_time_education,
        ];
    }
}
