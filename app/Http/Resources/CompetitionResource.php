<?php

namespace App\Http\Resources;

use App\Models\PersonalData;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $personalData = PersonalData::where('user_id', $this->users->id)->first();
        return [
            'first_name' => $personalData->first_name,
            'middle_name' => $personalData->middle_name,
            'last_name' => $personalData->last_name,
            'middlemark' => round($this->middlemark, 2)
        ];
    }
}
