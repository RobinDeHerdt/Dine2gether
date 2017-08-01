<?php

use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->insert([
            'title' => 'Home cooked vegan meal',
            'telephone_number' => '012/34.56.78',
            'street_number' => 'Vlinderstraat 10',
            'postalcode' => 2220,
            'host_id' => 1,
            'city' => 'Heist-op-den-Berg',
            'price' => 25.00,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Vegan meal',
            'telephone_number' => '012/34.56.78',
            'street_number' => 'Liersesteenweg 201A',
            'postalcode' => 2000,
            'host_id' => 3,
            'city' => 'Antwerpen',
            'price' => 95.00,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Italian home cooking',
            'telephone_number' => '012/34.56.78',
            'street_number' => 'Boekenstraat 180',
            'postalcode' => 5000,
            'host_id' => 1,
            'city' => 'Hasselt',
            'price' => 99.99,
        ]);

        DB::table('bookings')->insert([
            'title' => 'Sexy salsas',
            'telephone_number' => '012/34.56.78',
            'street_number' => 'Landweg 1',
            'host_id' => 2,
            'postalcode' => 3999,
            'city' => 'Bavikhove',
            'price' => 1.95,
        ]);
    }
}
