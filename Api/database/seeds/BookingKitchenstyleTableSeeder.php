<?php

use Illuminate\Database\Seeder;

class BookingKitchenstyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 3,
            'kitchenstyle_id' => 1,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 2,
            'kitchenstyle_id' => 2,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 4,
            'kitchenstyle_id' => 3,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 1,
            'kitchenstyle_id' => 4,
        ]);
    }
}
