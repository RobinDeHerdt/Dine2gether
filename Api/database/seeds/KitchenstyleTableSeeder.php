<?php

use Illuminate\Database\Seeder;

class KitchenstyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kitchenstyles')->insert([
            'style' => 'Italian',
            'booking_id' => 1,
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Chinese',
            'booking_id' => 2,
        ]);

         DB::table('kitchenstyles')->insert([
            'style' => 'Greek',
            'booking_id' => 3,
        ]);
    }
}
