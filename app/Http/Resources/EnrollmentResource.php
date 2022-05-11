<?php

namespace App\Http\Resources;

use App\Models\PersonalData;

use App\Models\School;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = PersonalData::where('user_id', $this->user_id)->first();

        switch ($user) {
            case $user->orphan:
                $disabled = "Сирота";
                break;
            case $user->childhood_disabled:
                $disabled = "Инвалид детства";
                break;
            case $user->the_large_family:
                $disabled = "Многодетная семья";
                break;
            case $user->orphan && $user->childhood_disabled && !$user->the_large_family:
                $disabled = "Сирота; Инвалид детства";
                break;
            case $user->orphan && $user->the_large_family && !$user->childhood_disabled:
                $disabled = "Сирота; Многодетная семья";
                break;
            case $user->childhood_disabled && $user->the_large_family && !$user->orphan:
                $disabled = "Инвалид детства; Многодетная семья";
                break;
            case $user->orphan && $user->the_large_family && $user->childhood_disabled:
                $disabled = "Сирота; Инвалид детства; Многодетная семья";
                break;
            default:
                $disabled = null;
        }

        return [
            "id" => $user->user_id,
            "first_name" => $user->first_name,
            "middle_name" => $user->middle_name,
            "last_name" => $user->last_name,
            "middlemark" => School::where('user_id', $this->user_id)->first()->middlemark,
            'disabled' => $disabled
        ];
    }
}

