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
            'interest' => 'Halal',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Vegetarisch',
            'user_id' => 1,
        ]);

        DB::table('interests')->insert([
            'interest' => 'Koosjer',
            'user_id' => 5,
        ]);
    }
}
