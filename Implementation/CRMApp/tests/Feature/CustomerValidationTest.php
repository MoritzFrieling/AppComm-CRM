<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class CustomerValidationTest extends TestCase
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

        $this->repositoryMock = $this->cmock('App\Interfaces\CustomerRepositoryInterface');
    }

    public function cmock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Tests that validation fails when creating or updating customers.
     * Using test data from validationFailTestDataProvider().
     * Testing both missing (e.g. customer_name) and invalid data (e.g. email).
     *
     * @dataProvider validationFailTestDataProvider
     * @param string $url
     * @param bool $createFirst
     * @param string $method
     * @param array $data
     * @param array $errors
     * @return void
     */
    function test_customer_create_and_update_validation_fails(string $url, bool $createFirst, string $method,
                                                              array  $data, array $errors): void
    {
        $this->repositoryMock->shouldReceive('find')->andReturn(new Customer([
                                                                                 'customer_name' => 'Test Customer',
                                                                                 'registration_number' => '123456789',
                                                                                 'vat_number' => '987654321',
                                                                                 'email' => 'example@test.com',
                                                                                 'website' => 'https://example.com',
                                                                                 'address_street' => 'Test Street',
                                                                                 'address_house_number' => '1',
                                                                                 'address_postal_code' => '1234 AB',
                                                                                 'address_city' => 'Test City',
                                                                                 'address_country' => 'Test Country',
                                                                                 'address_additional_information' => 'Test Additional Information',
                                                                             ]));
        $this->repositoryMock->shouldNotReceive('create', 'update', 'delete', 'setActive');
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json($method, $url, $data);
        $response->assertStatus(422);
        $response->assertJsonFragment($errors);
    }

    /**
     * Data provider for test_customer_create_and_update_validation_fails().
     * @return array
     */
    static function validationFailTestDataProvider(): array
    {
        $methodAndUrls = [
            'POST' => ['/customers', false],
            'PUT' => ['/customers/123456789', true],
        ];

        $dataAndErrors = [
            [
                ['POST', 'PUT'],
                [
                    'registration_number' => '123456789',
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
                ['customer_name' => ['The customer name field is required.']]
            ],
            [
                ['POST'],
                [
                    'customer_name' => 'Test Customer',
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
                ['registration_number' => ['The registration number field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['vat_number' => ['The vat number field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['address_street' => ['The address street field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
//                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['address_house_number' => ['The address house number field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
//                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['address_postal_code' => ['The address postal code field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
//                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['address_city' => ['The address city field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
//                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['address_country' => ['The address country field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['email' => ['The email field must be a valid email address.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'example',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['website' => ['The website field must be a valid URL.']]
            ]
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
     * @param array|Customer $return
     * @return void
     */
    function test_customer_create_and_update_validation_passes(string         $url, bool $createFirst, string $method,
                                                               array          $data, array $methodNames,
                                                               array|Customer $return): void
    {
        $this->repositoryMock->shouldReceive('find')->andReturn(new Customer([
                                                                                 'customer_name' => 'Test Customer',
                                                                                 'registration_number' => '123456789',
                                                                                 'vat_number' => '987654321',
                                                                                 'email' => 'example@test.com',
                                                                                 'website' => 'https://example.com',
                                                                                 'address_street' => 'Test Street',
                                                                                 'address_house_number' => '1',
                                                                                 'address_postal_code' => '1234 AB',
                                                                                 'address_city' => 'Test City',
                                                                                 'address_country' => 'Test Country',
                                                                                 'address_additional_information' => 'Test Additional Information',
                                                                             ]));
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
            'POST' => ['/customers', false],
            'PUT' => ['/customers/123456789', true],
        ];

        $dataAndErrors = [
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
//                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['create', 'update'],
                new Customer([
                                 'customer_name' => 'Test Customer',
                                 'registration_number' => '123456789',
                                 'vat_number' => '987654321',
//                    'email' => 'example@test.com',
                                 'website' => 'https://example.com',
                                 'address_street' => 'Test Street',
                                 'address_house_number' => '1',
                                 'address_postal_code' => '1234 AB',
                                 'address_city' => 'Test City',
                                 'address_country' => 'Test Country',
                                 'address_additional_information' => 'Test Additional Information',
                             ]),
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
//                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
                    'address_additional_information' => 'Test Additional Information',
                ],
                ['create', 'update'],
                new Customer([
                                 'customer_name' => 'Test Customer',
                                 'registration_number' => '123456789',
                                 'vat_number' => '987654321',
                                 'email' => 'example@test.com',
//                    'website' => 'https://example.com',
                                 'address_street' => 'Test Street',
                                 'address_house_number' => '1',
                                 'address_postal_code' => '1234 AB',
                                 'address_city' => 'Test City',
                                 'address_country' => 'Test Country',
                                 'address_additional_information' => 'Test Additional Information',
                             ]),
            ],
            [
                ['POST', 'PUT'],
                [
                    'customer_name' => 'Test Customer',
                    'registration_number' => '123456789',
                    'vat_number' => '987654321',
                    'email' => 'example@test.com',
                    'website' => 'https://example.com',
                    'address_street' => 'Test Street',
                    'address_house_number' => '1',
                    'address_postal_code' => '1234 AB',
                    'address_city' => 'Test City',
                    'address_country' => 'Test Country',
//                    'address_additional_information' => 'Test Additional Information',
                ],
                ['create', 'update'],
                new Customer([
                                 'customer_name' => 'Test Customer',
                                 'registration_number' => '123456789',
                                 'vat_number' => '987654321',
                                 'email' => 'example@test.com',
                                 'website' => 'https://example.com',
                                 'address_street' => 'Test Street',
                                 'address_house_number' => '1',
                                 'address_postal_code' => '1234 AB',
                                 'address_city' => 'Test City',
                                 'address_country' => 'Test Country',
//                    'address_additional_information' => 'Test Additional Information',
                             ]),
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
