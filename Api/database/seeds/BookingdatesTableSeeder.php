<?php

use Illuminate\Database\Seeder;

class BookingdatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("bookingdates")->insert([
            'date' => "2016-11-11 19:00:00",
            'booking_id' => 1,
            'max_guests' => 5,
        ]);

        DB::table("bookingdates")->insert([
            'date' => "2016-11-25 17:00:00",
            'booking_id' => 2,
            'max_guests' => 3,
        ]);

        DB::table("bookingdates")->insert([
            'date' => "2016-11-25 17:00:00",
            'booking_id' => 3,
            'max_guests' => 17,
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 1,
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 1,
            'bookingdate_id' => 3,
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 2,
        ]);
    }
}
