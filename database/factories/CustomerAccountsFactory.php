<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\customer_accounts;

class CustomerAccountsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerAccounts::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'customer_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'customer_company' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'customer_phone' => $this->faker->regexify('[A-Za-z0-9]{15}'),
            'description' => $this->faker->text(),
            'buying' => $this->faker->text(),
            'deposit' => $this->faker->text(),
            'remaining' => $this->faker->text(),
            'agent_manager' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'agent_id' => $this->faker->numberBetween(-10000, 10000),
            'customer_email' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
