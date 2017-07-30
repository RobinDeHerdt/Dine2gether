<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            'body' => 'Awesome experience.',
            'author_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Pretty bad.',
            'author_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Great experience.',
            'author_id' => 2,
            'user_id' => 1,
        ]);
    }
}
