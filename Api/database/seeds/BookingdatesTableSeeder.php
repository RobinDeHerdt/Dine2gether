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
            'host_approved' => true
        ]);

        DB::table("bookingdates")->insert([
            'date' => "2017-11-12 18:00:00",
            'booking_id' => 1,
            'max_guests' => 6,
            'host_approved' => true
        ]);

        DB::table("bookingdates")->insert([
            'date' => "2017-11-25 17:00:00",
            'booking_id' => 2,
            'max_guests' => 3,
            'host_approved' => true
        ]);

        DB::table("bookingdates")->insert([
            'date' => "2017-09-25 17:00:00",
            'booking_id' => 4,
            'max_guests' => 6,
            'host_approved' => true
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 3,
            'bookingdate_id' => 2,
            'status' => 'accepted',
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 2,
            'status' => 'pending',
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 1,
            'status' => 'accepted',
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 3,
            'bookingdate_id' => 3,
            'status' => 'accepted',
        ]);

        DB::table('bookingdate_user')->insert([
            'user_id' => 3,
            'bookingdate_id' => 1,
            'status' => 'pending',
            'optional_message_guest' => 'Hey there! I\'d like to join'
        ]);
    }
}
