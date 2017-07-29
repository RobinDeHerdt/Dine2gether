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
            'image_url' => 'foodImage1.jpg',
            'dish_id' => 1,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage2.jpg',
            'dish_id' => 2,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage3.jpg',
            'dish_id' => 3,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage4.jpg',
            'dish_id' => 4,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage5.jpg',
            'dish_id' => 5,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage6.jpg',
            'dish_id' => 6,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage7.jpg',
            'dish_id' => 7,
        ]);

        DB::table('dish_images')->insert([
            'image_url' => 'foodImage1.jpg',
            'dish_id' => 8,
        ]);
    }
}
