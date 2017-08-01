<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Robin',
            'last_name' => 'De Herdt',
            'email' => 'robin.deherdt@student.kdg.be',
            'image' => 'images/profile/friendseating.jpg',
            'street_number' => 'Vlinderstraat 10',
            'city' => 'Heist-op-den-Berg',
            'postalcode' => '2220',
            'password' => bcrypt('123456'),
            'activated' => true
        ]);

        DB::table('users')->insert([
            'first_name' => 'Sharon',
            'last_name' => 'Meeus',
            'image' => 'images/profile/friendseating.jpg',
            'street_number' => 'Molenstraat 123',
            'city' => 'Olen',
            'postalcode' => '2000',
            'email' => 'sharon.meeus@student.kdg.be',
            'password' => bcrypt('azerty'),
            'activated' => true
        ]);

        DB::table('users')->insert([
            'first_name' => 'Bob',
            'last_name' => 'Bouwman',
            'city' => 'Eindhoven',
            'email' => 'bob.bouwman@kdg.be',
            'password' => bcrypt('azerty'),
            'activated' => true
        ]);
    }
}
