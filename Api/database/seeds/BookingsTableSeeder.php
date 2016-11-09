<?php

use Illuminate\Database\Seeder;
// use Carbon\Carbon

class BookingsTableSeeder extends Seeder
{
	// $date = Carbon::now();

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->insert([
            'title' => 'Home cooked vegan meal',
            'max_guests' => 5,
            'street_number' => 'Vlinderstraat 10',
            'postalcode' => 2220,
            'city' => 'Heist-op-den-Berg',
            'price' => 25.00,
            'host_id' => 1,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Vegan meal',
            'max_guests' => 10,
            'street_number' => 'Liersesteenweg 201A',
            'postalcode' => 2000,
            'city' => 'Antwerpen',
            'price' => 95.00,
            'host_id' => 1,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Italian home cooking',
            'max_guests' => 4,
            'street_number' => 'Boekenstraat 180',
            'postalcode' => 5000,
            'city' => 'Hasselt',
            'price' => 99.99,
            'host_id' => 4,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Sexy salsas',
            'max_guests' => 3,
            'street_number' => 'Landweg 1',
            'postalcode' => 3999,
            'city' => 'Bavikhove',
            'price' => 1.95,
            'host_id' => 3,
        ]);
    }
}
