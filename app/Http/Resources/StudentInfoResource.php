<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->rfid_code,
            $this->first_name.' '.$this->last_name,
            $this->gradeLevel->name.' - '.$this->section->name,
            $this->student_number,
            $this->points !== 0 ? $this->points : 0,
            $this->object_type
        ];
    }
}
