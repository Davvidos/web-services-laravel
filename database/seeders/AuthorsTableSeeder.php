<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Author;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->delete();

        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Author::create([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
            ]);
        }
    }
}
