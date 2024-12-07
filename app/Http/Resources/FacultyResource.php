<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacultyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->title. ' '.$this->first_name. ' ' .$this->last_name,
            'profilePic' => $this->getFirstMediaUrl('profile') ?? ''
        ];
    }
}
