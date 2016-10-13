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
            'rating' => 5,
            'host_id' => 1,
            'guest_id' => 2,
        ]);

        DB::table('reviews')->insert([
            'body' => 'Amai da trok op niks.',
            'rating' => 1,
            'host_id' => 1,
            'guest_id' => 2,
        ]);
    }
}
