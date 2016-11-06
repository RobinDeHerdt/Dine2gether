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
            'guest_id' => 2,
            'booking_id' => 1,
        ]);

        DB::table('booking_user')->insert([
            'guest_id' => 2,
            'booking_id' => 2,
        ]);

        DB::table('booking_user')->insert([
            'guest_id' => 4,
            'booking_id' => 3,
        ]);

        DB::table('booking_user')->insert([
            'guest_id' => 5,
            'booking_id' => 3,
        ]);
    }
}
