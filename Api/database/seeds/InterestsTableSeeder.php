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
            'interest' => 'Muziek',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Sport',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Firing people',
            'user_id' => 5,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Keeping email secret',
            'user_id' => 4,
        ]);
    }
}
