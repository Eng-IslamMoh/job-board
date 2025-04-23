<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobAttributeValue>
 */
class JobAttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $attribute = Attribute::inRandomOrder()->first() ?? Attribute::factory()->create();
        $value = match ($attribute->type) {
            'text' => $this->faker->word,
            'number' => $this->faker->numberBetween(1, 10),
            'boolean' => $this->faker->boolean(),
            'date' => $this->faker->date(),
            'select' => Arr::random(json_decode($attribute->options, true) ?? ['junior', 'mid', 'senior']),
            default => 'N/A',
        };

        return [
            'attribute_id' => $attribute->id,
            'value' => $value,
        ];
    }
}
