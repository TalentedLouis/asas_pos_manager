<?php

namespace Database\Factories;

use App\Models\ConfigTax;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigTaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfigTax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomTax1 = $this->faker->randomFloat(2,0,100);
        $randomTax2 = $this->faker->randomFloat(2,0,100);
        return [
            'tax_rate1'=>$randomTax1,
            'tax_rate2'=>$randomTax2,
            'started_on'=>$this->faker->date(),
        ];
    }
}
