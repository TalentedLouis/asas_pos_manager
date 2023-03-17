<?php

namespace Database\Factories;

use App\Models\SupplierTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierTargetFactory extends Factory
{
    protected $model = SupplierTarget::class;

    public function definition()
    {
        return [
            'name'=>$this->faker->company(),
        ];
    }
}
