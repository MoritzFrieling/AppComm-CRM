<?php


use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerSearchFilterTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Data provider for test_customer_create_and_update_validation_fails().
     * @return array
     */
    static function validationFailTestDataProvider(): array
    {
        return [
            [
                ['search' => 'Customer 1'],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                ['search' => '123456789'],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                ['search' => 'Test Street 1'],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                ['search' => '4321 CD'],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                ['search' => 'Test City 1'],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City 1',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City 2',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'Customer 1',
                            'type' => ['property' => 'customer_name'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => '123456789',
                            'type' => ['property' => 'vat_number'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'Test Street 1',
                            'type' => ['property' => 'address_street'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => '4321 CD',
                            'type' => ['property' => 'address_postal_code'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'Test City 1',
                            'type' => ['property' => 'address_city'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'customer_name' => 'Customer 1',
                        'vat_number' => '123456789',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 1',
                        'address_house_number' => '1',
                        'address_postal_code' => '4321 CD',
                        'address_city' => 'Test City 1',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ],
                    [
                        'customer_name' => 'Customer 2',
                        'vat_number' => '987654321',
                        'email' => 'example@test.com',
                        'website' => 'https://example.com',
                        'address_street' => 'Test Street 2',
                        'address_house_number' => '1',
                        'address_postal_code' => '1234 AB',
                        'address_city' => 'Test City 2',
                        'address_country' => 'Test Country',
                        'address_additional_information' => 'Test Additional Information',
                    ]
                ],
            ],
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Tests that search and filter only returns matching customers.
     *
     * @dataProvider validationFailTestDataProvider
     * @param array $data
     * @param array $customers
     * @return void
     */
    function test_customer_search_only_returns_matching(
        array $data,
        array $customers
    ): void {
        foreach ($customers as $customer) {
            Customer::factory()->create(
                array_merge([
                    'registration_number' => $this->faker->randomNumber(9, true),
                ], $customer)
            );
        }
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('customers.index', $data), [
            'X-Inertia' => 'true',
        ]);
        $response->assertStatus(200);
        dump($data, $response->json());
        self::assertEquals($response->json()['props']['customers']['total'], 1);
    }

}
