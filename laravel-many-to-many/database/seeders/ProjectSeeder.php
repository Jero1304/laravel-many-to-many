<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project;
use illuminate\Support\Str;
use App\Models\Type;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $type_ids = Type::all()->pluck('id')->all();
        for ($i = 0; $i < 100; $i++) {
            $project = new Project();
            $project->title = $faker->unique()->sentence($faker->numberBetween(3, 5));
            $project->content = $faker->optional()->text(200);
            $project->slug = Str::slug($project->title, '-');
            $project->type_id = $faker->optional()->randomElement($type_ids);
            $project->save();
        }
    }
}