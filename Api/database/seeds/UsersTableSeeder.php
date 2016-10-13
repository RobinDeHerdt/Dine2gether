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

        DB::table('users')->insert([
            'first_name' => 'Bob',
            'last_name' => 'Bouwman',
            'email' => 'bob.bouwman@kdg.be',
            'password' => bcrypt('azerty'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Hillary',
            'last_name' => 'Clinton',
            'email' => 'hillary@secretemailserver.home',
            'password' => bcrypt('qwerty'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Donald',
            'last_name' => 'Trump',
            'email' => 'yourefired@trump.com',
            'password' => bcrypt('qwerty'),
        ]);
    }
}
