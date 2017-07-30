<?php

use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->insert([
            'name' => 'Music',
        ]);

        DB::table('interests')->insert([
            'name' => 'Sports',
        ]);

        DB::table('interests')->insert([
            'name' => 'Animals',
        ]);

        DB::table('interests')->insert([
            'name' => 'Languages',
        ]);

        DB::table('interests')->insert([
            'name' => 'Books',
        ]);

        DB::table('interests')->insert([
            'name' => 'Movies',
        ]);


        DB::table('user_interest')->insert([
            'user_id' => 3,
            'interest_id' => 1,
        ]);

        DB::table('user_interest')->insert([
            'user_id' => 2,
            'interest_id' => 2,
        ]);

        DB::table('user_interest')->insert([
            'user_id' => 1,
            'interest_id' => 3,
        ]);
    }
}
