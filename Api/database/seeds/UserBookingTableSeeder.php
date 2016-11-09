<?php

use Illuminate\Database\Seeder;

class UserBookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 1,
        ]);

        DB::table('booking_user')->insert([
            'user_id' => 1,
            'bookingdate_id' => 3,
        ]);

        DB::table('booking_user')->insert([
            'user_id' => 2,
            'bookingdate_id' => 2,
        ]);

        DB::table('booking_user')->insert([
            'user_id' => 4,
            'bookingdate_id' => 3,
        ]);

        DB::table('booking_user')->insert([
            'user_id' => 5,
            'bookingdate_id' => 3,
        ]);
    }
}
