<?php

use Illuminate\Database\Seeder;

class BookingInterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_interest')->insert([
            'booking_id' => 3,
            'interest_id' => 1,
        ]);

        DB::table('booking_interest')->insert([
            'booking_id' => 2,
            'interest_id' => 2,
        ]);

        DB::table('booking_interest')->insert([
            'booking_id' => 4,
            'interest_id' => 3,
        ]);

        DB::table('booking_interest')->insert([
            'booking_id' => 1,
            'interest_id' => 3,
        ]);
    }
}
