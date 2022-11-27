<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskShortResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'contractor_name' => $this->contractor_name,
            'contractor_surname' => $this->contractor_surname,
            'deadline' => $this->deadline,
            'statusId' => $this->status_id,
            'priorityId' => $this->priority_id
        ];
    }
}
