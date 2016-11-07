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
            'body' => 'Toffe avond.',
            'author_id' => 5,
            'receiver_id' => 1,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Toffe avond.',
            'author_id' => 4,
            'receiver_id' => 1,
        ]);
        DB::table('reviews')->insert([
            'body' => 'Toffe avond.',
            'author_id' => 1,
            'receiver_id' => 2,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Amai da trok op niks.',
            'author_id' => 1,
            'receiver_id' => 2,
        ]);

        DB::table('reviews')->insert([
            'body' => 'You\'re fired!',
            'author_id' => 1,
            'receiver_id' => 5,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Great experience.',
            'author_id' => 2,
            'receiver_id' => 1,
        ]);
    }
}
