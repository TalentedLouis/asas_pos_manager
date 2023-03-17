<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shop = Shop::inRandomOrder()->first();

        return [
            'name' => $this->faker->name() . ' Staff',
            'shop_id' => $shop
        ];
    }
}
