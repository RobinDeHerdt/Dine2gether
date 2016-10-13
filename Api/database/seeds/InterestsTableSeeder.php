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
            'interest' => 'Film',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Muziek',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Sport',
            'user_id' => 1,
        ]);
    }
}
