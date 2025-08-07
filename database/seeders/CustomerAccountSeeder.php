<?php

namespace Database\Seeders;

use App\Models\CustomerAccounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerAccounts::create([
            'customer_id' => "SKC-01",
            'customer_name' => 'John Doe',
            'customer_company' => 'Doe Enterprises',
            'customer_phone' => '+1234567890',
            'customer_whatsapp' => '+1234567890',
            'description' => 'Regular customer account',
            'address' => '123 Main St, Springfield',
            'city' => 'Springfield',
            'country' => 'USA',
            'buying' => 1000.00,
            'deposit' => 500.00,
            'remaining' => 500.00,
            'agent_manager' => 'Jane Smith',
            'agent_id' => 1,
            "currency" => 'USD',
            'customer_email' => 'test@example.com',
        ]);
    }
}
