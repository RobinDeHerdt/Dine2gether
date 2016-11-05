<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(InterestsTableSeeder::class);
        $this->call(BookingsTableSeeder::class);
        $this->call(UserBookingTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(DishesTableSeeder::class);
        $this->call(DishImagesTableSeeder::class);
        $this->call(KitchenstylesTableSeeder::class);
        $this->call(BookingInterestTableSeeder::class);
    }
}
