<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Traits\BarcodeTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    use BarcodeTrait;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customerCode = Date::now()->year . str_pad($this->faker->unique()->numberBetween(1,99999), 8, 0,STR_PAD_LEFT);
        $customerCode .= $this->calcCheckDigitJan13($customerCode);
        $gender = $this->faker->randomElement(['male', 'female']);
        $addr = explode('  ', $this->faker->address());

        return [
            'code'=>$customerCode,
            'customer_class_id'=>1,
            'name'=>$this->faker->name($gender),
            'sex'=>$gender == 'male' ? '男' : '女',
            'birthday'=>$this->faker->date(),
            'zip_code'=>$addr[0],
            'address_1'=>$addr[1],
            'tel'=>$this->faker->phoneNumber(),
        ];
    }
}
