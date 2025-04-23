<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{

    protected $realJobAttributes = [
        [
            'name' => 'years_experience',
            'type' => 'number',
            'options' => null
        ],
        [
            'name' => 'experience_level',
            'type' => 'select',
            'options' => ['junior', 'mid', 'senior']
        ],
        [
            'name' => 'requires_travel',
            'type' => 'boolean',
            'options' => null
        ],
        [
            'name' => 'start_date',
            'type' => 'date',
            'options' => null
        ],
        [
            'name' => 'benefits',
            'type' => 'text',
            'options' => null
        ],
        [
            'name' => 'team_size',
            'type' => 'number',
            'options' => null
        ],
        [
            'name' => 'interview_process',
            'type' => 'text',
            'options' => null
        ],
        [
            'name' => 'work_hours',
            'type' => 'text',
            'options' => null
        ],
        [
            'name' => 'tech_stack',
            'type' => 'text',
            'options' => null
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $attribute = Arr::random($this->realJobAttributes);
        return [
            'name' => $attribute['name'],
            'type' => $attribute['type'],
            'options' => isset($attribute['options'])
                ? json_encode($attribute['options'])
                : null,
        ];
    }

    public function createAllAttributes()
    {
        foreach ($this->realJobAttributes as $attribute) {
            $this->newModel()->create([
                'name' => $attribute['name'],
                'type' => $attribute['type'],
                'options' => isset($attribute['options'])
                    ? json_encode($attribute['options'])
                    : null,
            ]);
        }
    }
}
