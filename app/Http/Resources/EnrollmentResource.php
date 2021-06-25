<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $disabled = null;
        $user = User::find($this->user_id);
        if ($user->PersonalData->orphan) { // 1 0 0
            $disabled = "Сирота";
        }
        if ($user->PersonalData->childhood_disabled) { // 0 1 0
            $disabled = "Инвалид детства";
        }
        if ($user->PersonalData->the_large_family) { // 0 0 1
            $disabled = "Многодетная семья";
        }
        if ($user->PersonalData->orphan && $user->PersonalData->childhood_disabled && !$user->PersonalData->the_large_family) { // 1 1 0
            $disabled = "Сирота; Инвалид детства";
        }
        if ($user->PersonalData->orphan && $user->PersonalData->the_large_family && !$user->PersonalData->childhood_disabled) { // 1 0 1
            $disabled = "Сирота; Многодетная семья";
        }
        if ($user->PersonalData->childhood_disabled && $user->PersonalData->the_large_family && !$user->PersonalData->orphan) { // 0 1 1
            $disabled = "Инвалид детства; Многодетная семья";
        }
        if ($user->PersonalData->orphan && $user->PersonalData->the_large_family && $user->PersonalData->childhood_disabled) {
            $disabled = "Сирота; Инвалид детства; Многодетная семья";
        }

        return [
            "first_name" =>$user->PersonalData->first_name,
            "middle_name" => $user->PersonalData->middle_name,
            "last_name" => $user->PersonalData->last_name,
            "middlemark" => $user->School->middlemark,
            'disabled' => $disabled
        ];
    }
}
