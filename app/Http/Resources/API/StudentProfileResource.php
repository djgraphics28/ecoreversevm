<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "student_number" => $this->student_number,
            "rfid_code" => $this->rfid_code,
            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name,
            "birth_date" => $this->birth_date,
            "gender" => $this->gender,
            "grade_level" => $this->gradeLevel->name,
            "section" => $this->section->name,
            "points" => (int)$this->points,
            "email" => $this->email,
            'profile_pic' => $this->getFirstMediaUrl('student_pictures') ?? ''
        ];
    }
}
