<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word() . ' Plan',
            'use_minutes' => $this->faker->randomNumber(3),
            'use_start_hour' => $this->faker->randomNumber(1),
            'use_limit_hour' => $this->faker->randomNumber(1),
        ];
    }
}
