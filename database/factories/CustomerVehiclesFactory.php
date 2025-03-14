<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\customer_vehicles;

class CustomerVehiclesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerVehicles::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'stock_id' => $this->faker->regexify('[A-Za-z0-9]{15}'),
            'vehicle' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'customer_email' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'status' => $this->faker->regexify('[A-Za-z0-9]{15}'),
        ];
    }
}
