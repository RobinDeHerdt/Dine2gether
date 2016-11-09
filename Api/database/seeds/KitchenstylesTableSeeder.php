<?php

use Illuminate\Database\Seeder;

class KitchenstylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kitchenstyles')->insert([
            'style' => 'Italian',
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Greek',
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Mexican',
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Halal',
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Koosjer',
        ]);

        DB::table('kitchenstyles')->insert([
            'style' => 'Vegan',
        ]);
    }
}
