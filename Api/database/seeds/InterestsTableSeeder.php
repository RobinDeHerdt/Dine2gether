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
            'interest' => 'Music',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Sports',
            'user_id' => 2,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Animals',
            'user_id' => 5,
        ]);
    }
}
