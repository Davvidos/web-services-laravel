<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('articles')->delete();

        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Article::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'author_id' => rand(1, 50)
            ]);
        }
    }
}
