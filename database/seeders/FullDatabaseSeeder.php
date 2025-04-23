<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobAttributeValue;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FullDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        JobAttributeValue::truncate();
        DB::table('job_language')->truncate();
        DB::table('job_location')->truncate();
        DB::table('job_category')->truncate();
        Job::truncate();
        Language::truncate();
        Location::truncate();
        Category::truncate();
        Attribute::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $languages = Language::factory(20)->create();
        $locations = Location::factory(20)->create();
        $categories = Category::factory(20)->create();
        Attribute::factory()->createAllAttributes();

        Job::factory(500)->create()->each(function ($job) use ($languages, $locations, $categories) {
            $job->languages()->attach($languages->random(rand(1, 3))->pluck('id')->toArray());
            $job->locations()->attach($locations->random(rand(1, 2))->pluck('id')->toArray());
            $job->categories()->attach($categories->random(rand(1, 2))->pluck('id')->toArray());

            JobAttributeValue::factory(rand(2, 5))->create([
                'job_id' => $job->id,
            ]);
        });
    }
}
