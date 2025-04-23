<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $used = [];
        $categories = [
            'Web Development',
            'Mobile Development',
            'DevOps',
            'Data Science',
            'Machine Learning',
            'Artificial Intelligence',
            'Frontend',
            'Backend',
            'Full Stack',
            'QA',
            'UI/UX Design',
            'Product Management',
            'Project Management',
            'Database Administration',
            'Cloud Engineering',
            'Security',
            'Blockchain',
            'Game Development',
            'IoT',
            'AR/VR'
        ];

        $available = array_diff($categories, $used);

        $category = Arr::random($available);

        $used[] = $category;

        return [
            'name' => $category,
        ];
    }
}
