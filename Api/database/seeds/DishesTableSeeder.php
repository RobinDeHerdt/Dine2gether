<?php

use Illuminate\Database\Seeder;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dishes')->insert([
            'name' => 'Pizza',
            'description' => 'Pizza hawai',
            'booking_id' => 1,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Steak with fries.',
            'description' => 'Steak with fries description.',
            'booking_id' => 2,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Spaghetti',
            'description' => 'Spaghetti description.',
            'booking_id' => 2,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Ravioli',
            'description' => 'Ravioli description.',
            'booking_id' => 2,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Ravioli',
            'description' => 'Ravioli description.',
            'booking_id' => 3,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Macaroni',
            'description' => 'Macaroni with ham and cheese',
            'booking_id' => 3,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Ravioli',
            'description' => 'Ravioli description.',
            'booking_id' => 1,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Ravioli',
            'description' => 'Ravioli description.',
            'booking_id' => 4,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Macaroni',
            'description' => 'Macaroni with ham and cheese.',
            'booking_id' => 4,
        ]);
    }
}
