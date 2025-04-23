<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $used = [];
        $languages = [
            'PHP',
            'JavaScript',
            'Python',
            'Java',
            'C#',
            'Ruby',
            'Go',
            'Swift',
            'Kotlin',
            'TypeScript',
            'HTML',
            'CSS',
            'SQL',
            'Rust',
            'C++',
            'C',
            'Scala',
            'R',
            'Perl',
            'Dart'
        ];

        $available = array_diff($languages, $used);

        $language = Arr::random($available);

        $used[] = $language;

        return [
            'name' => $language,
        ];
    }
}
