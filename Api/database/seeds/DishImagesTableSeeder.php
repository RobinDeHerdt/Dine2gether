<?php

use Illuminate\Database\Seeder;

class DishImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dish_images')->insert([
            'image-url' => 'aJalkep.jpg',
            'dish_id' => 1,
        ]);

         DB::table('dish_images')->insert([
            'image-url' => 'paLdjMa.jpg',
            'dish_id' => 2,
        ]);
    }
}
