<?php

namespace App\Http\Resources\Job;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\JobAttributeValueResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'responsibilities' => $this->responsibilities,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'experience_years' => $this->experience_years,
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
            'attributes' => JobAttributeValueResource::collection($this->whenLoaded('attributes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
