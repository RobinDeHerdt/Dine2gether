<?php

use Illuminate\Database\Seeder;

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
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Sharon',
            'last_name' => 'Meeus',
            'email' => 'sharon.meeus@student.kdg.be',
            'password' => bcrypt('azerty'),
        ]);
    }
}
