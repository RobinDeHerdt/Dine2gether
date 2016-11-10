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
        	'booking_date' => "2016-11-11 19:00:00",
        	'booking_id' => 1,
            'host_id' => 4,
        ]);

        DB::table("bookingdates")->insert([
        	'booking_date' => "2016-11-25 17:00:00",
        	'booking_id' => 2,
            'host_id' => 1,
        ]);

        DB::table("bookingdates")->insert([
        	'booking_date' => "2016-11-25 17:00:00",
        	'booking_id' => 3,
            'host_id' => 4,
        ]);
    }
}