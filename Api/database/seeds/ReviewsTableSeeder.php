<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'booking_id' => 4,
            'created_at' => Carbon::create('2017', '06', '01'),
        ]);

        DB::table('reviews')->insert([
            'body' => 'Pretty bad.',
            'author_id' => 1,
            'user_id' => 3,
            'booking_id' => 2,
            'created_at' => Carbon::create('2017', '08', '02'),
        ]);

        DB::table('reviews')->insert([
            'body' => 'Great experience.',
            'author_id' => 2,
            'user_id' => 1,
            'booking_id' => 1,
            'created_at' => Carbon::create('2017', '10', '03'),
        ]);
    }
}
