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
        /*factory(App\User::class, 50)->create();

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
        ]);*/
        
        Model::unguard();

        DB::table('users')->delete();

        $users = array(
                [
                    'first_name' => 'Robin',
                    'last_name' => 'De Herdt', 
                    'email' => 'robin.deherdt@student.kdg.be',
                    'image' => 'img/friendseating.jpg',
                    'street_number' => 'Vlinderstraat 10',
                    'city' => 'Heist-op-den-Berg',
                    'postalcode' => '2220',
                    'password' => bcrypt('123456'),
                    'activated' => true
                ],
                [
                    'first_name' => 'Sharon',
                    'last_name' => 'Meeus',
                    'image' => 'img/friendseating.jpg',
                    'street_number' => 'Molenstraat 123',
                    'city' => 'Olen',
                    'postalcode' => '2000',
                    'email' => 'sharon.meeus@student.kdg.be',
                    'password' => bcrypt('azerty'),
                    'activated' => true
                ],
                [
                    'first_name' => 'Bob',
                    'last_name' => 'Bouwman',
                    'email' => 'bob.bouwman@kdg.be',
                    'password' => bcrypt('azerty'),
                    'activated' => true
                ],
                [
                    'first_name' => 'Hillary',
                    'last_name' => 'Clinton',
                    'email' => 'hillary@secretemailserver.home',
                    'password' => bcrypt('qwerty'),
                    'activated' => true
                ],
                [
                    'first_name' => 'Donald',
                    'last_name' => 'Trump',
                    'email' => 'yourefired@trump.com',
                    'password' => bcrypt('qwerty'),
                    'activated' => true
                ]
                
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        Model::reguard();
    }
}
