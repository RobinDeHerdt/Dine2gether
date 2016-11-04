<?php

use Illuminate\Database\Seeder;

class UserInterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_interest')->insert([
            'user_id' => 2,
            'interest_id' => 1,
        ]);

        DB::table('user_interest')->insert([
            'user_id' => 2,
            'interest_id' => 2,
        ]);

        DB::table('user_interest')->insert([
            'user_id' => 4,
            'interest_id' => 3,
        ]);

        DB::table('user_interest')->insert([
            'user_id' => 5,
            'interest_id' => 3,
        ]);
    }
}
