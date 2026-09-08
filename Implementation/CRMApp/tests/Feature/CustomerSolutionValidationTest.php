<?php

namespace Tests\Feature;

use App\Models\ContactPerson;
use App\Models\Customer;
use App\Models\CustomerSolution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CustomerSolutionValidationTest extends TestCase
{
    use RefreshDatabase;

    private $repositoryMock;

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->customerRepositoryMock = $this->cmock('App\Interfaces\CustomerRepositoryInterface');
        $this->repositoryMock = $this->cmock('App\Interfaces\CustomerSolutionRepositoryInterface');
    }

    public function cmock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }


    /**
     * Tests that validation fails when creating or updating contact persons.
     * Using test data from validationFailTestDataProvider().
     * Testing both missing (e.g. first_name) and invalid data (e.g. email).
     *
     * @dataProvider validationFailTestDataProvider
     * @param string $url
     * @param bool $createFirst
     * @param string $method
     * @param array $data
     * @param array $errors
     * @return void
     */
    function test_customer_solution_create_and_update_validation_fails(
        string $url,
        bool $createFirst,
        string $method,
        array $data,
        array $errors
    ): void {
        $this->repositoryMock->shouldNotHaveBeenCalled();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json($method, $url, $data);
        $response->assertStatus(422);
        dump($response->json(), $data);
        $response->assertJsonFragment($errors);
    }

    /**
     * Data provider for test_customer_create_and_update_validation_fails().
     * @return array
     */
    static function validationFailTestDataProvider(): array
    {
        $methodAndUrls = [
            'POST' => ['/customers/123456789/solutions/', false],
            'PUT' => ['/customers/123456789/solutions/1', true],
        ];

        $dataAndErrors = [
            [
                ['POST'],
                [
                    'solution_id' => '',
                ],
                [
                    'solution_id' => [
                        "The solution id field must be a number.",
                        "The solution id field is required."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'units' => '1',
                ],
                [
                    "price_per_unit" => [
                        "The price per unit field is required when units / recurring period / recurring period unit / vat rate / start date / end date is present."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'units' => '1',
                    'recurring_period' => '1'
                ],
                [
                    "price_per_unit" => [
                        "The price per unit field is required when units / recurring period / recurring period unit / vat rate / start date / end date is present."
                    ],
                    "start_date" => [
                        0 => "The start date field is required when recurring period / start date / end date is present."
                    ],
                    "end_date" => [
                        0 => "The end date field is required when recurring period / start date is present."
                    ],
                    "recurring_period_unit" => [
                        0 => "The recurring period unit field is required when recurring period / start date / end date is present."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'vat_rate' => '1',
                ],
                [
                    "vat_rate" => [
                        0 => "The vat rate field must not be greater than 0.99."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'vat_rate' => '-1',
                ],
                [
                    "vat_rate" => [
                        0 => "The vat rate field must be at least 0."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'price_per_unit' => '-1',
                ],
                [
                    "price_per_unit" => [
                        0 => "The price per unit field must be at least 0."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'price_per_unit' => '1.111',
                ],
                [
                    "price_per_unit" => [
                        0 => "The price per unit field must have 0-2 decimal places."
                    ]
                ]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_id' => '1',
                ],
                [
                    "customer_id" => [
                        "The customer id field must be missing."
                    ]
                ]
            ],
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
                if ($method === 'PUT') {
                    // remove registration_number from data
                    unset($dataAndError[1]['registration_number']);
                }
                $result[] = [
                    $methodAndUrls[$method][0],
                    $methodAndUrls[$method][1],
                    $method,
                    $dataAndError[1],
                    $dataAndError[2]
                ];
            }
        }

        return $result;
    }

    /**
     * Tests that validation passes when creating or updating customers.
     * Using test data from validationPassTestDataProvider().
     * Tests that missing data that is not required (e.g. email and website) doesn't fail validation.
     *
     * @dataProvider validationPassTestDataProvider
     * @param string $url
     * @param bool $createFirst
     * @param string $method
     * @param array $data
     * @param array $methodNames
     * @param CustomerSolution $return
     * @return void
     */
    function test_customer_solution_and_update_validation_passes(
        string $url,
        bool $createFirst,
        string $method,
        array $data,
        array $methodNames,
        CustomerSolution $return
    ): void {
        $return->id = 1;
        $this->repositoryMock->shouldReceive(...$methodNames)->andReturn($return);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json($method, $url, $data);
        $response->assertStatus(302);
    }

    /**
     * Data provider for test_customer_create_and_update_validation_passes().
     * @return array
     */
    static function validationPassTestDataProvider(): array
    {
        $methodAndUrls = [
            'POST' => ['/customers/123456789/solutions', false],
            'PUT' => ['/customers/123456789/solutions/1', true],
        ];

        $dataAndErrors = [
            [
                ['POST'],
                [
                    'solution_id' => '1',
                    'start_date' => '2023-01-01',
                    'end_date' => '2023-12-31',
                    'units' => '1',
                    'price_per_unit' => '1',
                    'recurring_period' => '1',
                    'recurring_period_unit' => 'month',
                    'vat_rate' => '0.07',
                    'description' => ''
                ],
                ['create', 'update'],
                new CustomerSolution(
                    [
                        'first_name' => 'Test First Name',
                        'last_name' => 'Test Last Name',
                        'gender' => 'd',
                        'email' => 'example@test.com',
                        'phone_number' => '0612345678',
                        'function' => 'Test Function',
                    ],
                ),
            ],
            [
                ['PUT'],
                [
                    'solution_id' => 1,
                    'start_date' => '2023-01-01',
                    'end_date' => '2023-12-31',
                    'units' => '1',
                    'price_per_unit' => '1',
                    'recurring_period' => '1',
                    'recurring_period_unit' => 'month',
                    'vat_rate' => '0.07',
                    'description' => ''
                ],
                ['create', 'update'],
                new CustomerSolution(
                    [
                        'first_name' => 'Test First Name',
                        'last_name' => 'Test Last Name',
                        'gender' => 'd',
                        'email' => 'example@test.com',
                        'phone_number' => '0612345678',
                        'function' => 'Test Function',
                    ],
                ),
            ],
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
                if ($method === 'PUT') {
                    // remove registration_number from data
                    unset($dataAndError[1]['registration_number']);
                }
                $result[] = [
                    $methodAndUrls[$method][0],
                    $methodAndUrls[$method][1],
                    $method,
                    $dataAndError[1],
                    $dataAndError[2],
                    $dataAndError[3]
                ];
            }
        }

        return $result;
    }

}
