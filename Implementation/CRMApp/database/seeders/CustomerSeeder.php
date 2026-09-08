<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Create 10 customers
        $faker = Factory::create('nl_NL');
        foreach (range(1, 10) as $index) {
            $customer = Customer::query()->create(
                [
                    'customer_name' => $faker->company,
                    'vat_number' => "NL" . $faker->randomNumber(
                            5,
                            true
                        ) . $faker->randomNumber(
                            5,
                            true
                        ) . "B00",
                    'registration_number' => $faker->randomNumber(8, true),
                    'email' => $faker->companyEmail,
                    'website' => $faker->url,
                    'address_street' => $faker->streetName,
                    'address_house_number' => $faker->buildingNumber,
                    'address_city' => $faker->city,
                    'address_postal_code' => $faker->postcode,
                    'address_country' => $faker->country,
                    'address_additional_information' => null,
                ]
            );
//            Create 2 contact persons for each customer
            foreach (range(1, 2) as $index) {
                $randomElement = $faker->randomElement(['m', 'f', 'd']);
                $customer->contact_persons()->create(
                    [
                        'first_name' => $faker->firstName($randomElement),
                        'middle_name' => $faker->randomElement(['', $faker->firstName($randomElement)]),
                        'last_name' => $faker->lastName,
                        'email' => $faker->email,
                        'phone_number' => $faker->phoneNumber,
                        'function' => $faker->jobTitle,
                        'gender' => $randomElement,
                    ]
                );
            }
        }
    }
}
