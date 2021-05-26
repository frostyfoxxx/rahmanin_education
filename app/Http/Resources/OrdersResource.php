<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'order_number'=>$this->order_number,
            'date'=>$this->date,
            'reason'=>$this->reason,
            'prepared'=>$this->prepared,
        ];
    }
}
