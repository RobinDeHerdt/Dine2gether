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
        	'date' => '2016/10/14 19:00:00',
            'street_number' => 'Vlinderstraat 10',
            'postalcode' => 2220,
            'city' => 'Heist-op-den-Berg',
            'price' => 23,
            'host_id' => 1,
        ]);

        DB::table('bookings')->insert([
        	'date' => '2016/10/14 17:30:00',
            'street_number' => 'Liersesteenweg 201A',
            'postalcode' => 2000,
            'city' => 'Antwerpen',
            'price' => 95,
            'host_id' => 1,
        ]);
    }
}
