<?php

namespace App\Http\Resources;

use App\Models\PersonalData;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeWindowSecretaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user_id != null) {
            $user = User::find($this->user_id);
            $personalData = PersonalData::where('user_id', $user->id)->first();
            return [
                'id' => $this->id,
                'time' => $this->recording_start,
                'occupied' => ($this->user_id == null) ? false : true,
                'user_occupied' => $personalData->first_name. ' ' . $personalData->middle_name . " " . $personalData->last_name
            ];
        } else {
            return [
                'id' => $this->id,
                'time' => $this->recording_start,
                'occupied' => ($this->user_id == null) ? false : true,
                'user_occupied' => null
            ];
        }
    }
}
