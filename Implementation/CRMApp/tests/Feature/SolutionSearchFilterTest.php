<?php


use App\Models\Customer;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SolutionSearchFilterTest extends TestCase
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
                ['search' => 'Solution 1'],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',





                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'Solution 1',
                            'type' => ['property' => 'title'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ]
                ],
            ],
            [
                ['search' => 'Service'],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Product',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'Service',
                            'type' => ['property' => 'category'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Product',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ]
                ],
            ],
            [
                ['search' => 'https://example.com'],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Product',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example2.com',
                    ]
                ],
            ],
            [
                [
                    'filters' => [
                        [
                            'value' => 'https://example.com',
                            'type' => ['property' => 'description'],
                            'operator' => '='
                        ]
                    ]
                ],
                [
                    [
                        'title' => 'Solution 1',
                        'category' => 'Service',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example.com',
                    ],
                    [
                        'title' => 'Solution 2',
                        'category' => 'Product',
                        'price_per_unit' => 100,
                        'units' => 1,
                        'vat_rate' => 0.20,
                        'description' => 'https://example2.com',
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
            Solution::factory()->create(
                array_merge([
                    'number' => $this->faker->randomNumber(9, true),
                ], $customer)
            );
        }
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('solutions.index', $data), [
            'X-Inertia' => 'true',
        ]);
        $response->assertStatus(200);
        dump($data, $response->json());
        self::assertEquals($response->json()['props']['solutions']['total'], 1);
    }

}
