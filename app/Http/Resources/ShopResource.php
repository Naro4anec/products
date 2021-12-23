<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id
            ,'name' => $this->name
            ,'url' => $this->url
            ,'working_time_open' => $this->working_time_open
            ,'working_time_close' => $this->working_time_close
        ];
    }
}
