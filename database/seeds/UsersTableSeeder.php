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
            'name' => 'Robin',
            'email' => 'robin.deherdt@student.kdg.be',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Sharon',
            'email' => 'sharon.meeus@student.kdg.be',
            'password' => bcrypt('azerty'),
        ]);
    }
}
