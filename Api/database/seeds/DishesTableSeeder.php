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
            'description' => 'Generische pizza.',
            'booking_id' => 1,
        ]);

        DB::table('dishes')->insert([
            'name' => 'Steak met frieten.',
            'description' => 'Steak met frieten beschrijving.',
            'booking_id' => 2,
        ]);
    }
}
