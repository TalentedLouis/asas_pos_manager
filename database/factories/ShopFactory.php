<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition()
    {
        return [
            'code'=>$this->faker->unique()->numberBetween(1,999),
            'name'=>$this->faker->streetName(),
        ];
    }
}
