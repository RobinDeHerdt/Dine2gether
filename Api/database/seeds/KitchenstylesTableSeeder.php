<?php

use Illuminate\Database\Seeder;

class KitchenstylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kitchenstyles')->insert([
            'name' => 'Italian',
        ]);

        DB::table('kitchenstyles')->insert([
            'name' => 'Greek',
        ]);

        DB::table('kitchenstyles')->insert([
            'name' => 'Mexican',
        ]);

        DB::table('kitchenstyles')->insert([
            'name' => 'Halal',
        ]);

        DB::table('kitchenstyles')->insert([
            'name' => 'Koosjer',
        ]);

        DB::table('kitchenstyles')->insert([
            'name' => 'Vegan',
        ]);


        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 3,
            'kitchenstyle_id' => 1,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 2,
            'kitchenstyle_id' => 6,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 4,
            'kitchenstyle_id' => 3,
        ]);

        DB::table('booking_kitchenstyle')->insert([
            'booking_id' => 1,
            'kitchenstyle_id' => 6,
        ]);
    }
}
