<?php

use Illuminate\Database\Seeder;
use App\Dish;
use App\User;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dish::class, 10) -> make() -> each(function($dish) {

            $user = User::inRandomOrder() -> limit(1);
            $dish -> user() -> associate($user);

            $dish -> save();
        });

    }
}
