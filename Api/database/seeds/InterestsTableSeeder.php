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
        ]);

        DB::table('interests')->insert([
            'interest' => 'Sports',
        ]);

        DB::table('interests')->insert([
            'interest' => 'Animals',
        ]);

        DB::table('interests')->insert([
            'interest' => 'Languages',
        ]);

        DB::table('interests')->insert([
            'interest' => 'Movies',
        ]);

        DB::table('interests')->insert([
            'interest' => 'Books',
        ]);

        DB::table('interests')->insert([
            'interest' => 'Movies',
        ]);
    }
}
