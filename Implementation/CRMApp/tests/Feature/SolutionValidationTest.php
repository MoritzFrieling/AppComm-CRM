<?php

namespace Tests\Feature;

use App\Models\Solution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class SolutionValidationTest extends TestCase
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

        $this->repositoryMock = $this->cmock('App\Interfaces\SolutionRepositoryInterface');
    }

    public function cmock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Tests that validation fails when creating or updating solutions.
     * Using test data from validationFailTestDataProvider().
     * Testing both missing (e.g. title) and invalid data (e.g. email).
     *
     * @dataProvider validationFailTestDataProvider
     * @param string $url
     * @param bool $createFirst
     * @param string $method
     * @param array $data
     * @param array $errors
     * @return void
     */
    function test_solution_create_and_update_validation_fails(string $url, bool $createFirst, string $method,
        array  $data, array $errors): void
    {
        dump($data, $errors);
        $this->repositoryMock->shouldReceive('create')->andReturn(new Solution([
            'title' => 'Test Solution',
            'number' => 123456789,
            'category' => 'Product',
            'price_per_unit' => '100',
            'units' => 1,
            'vat_rate' => 0,20,
            'description' => 'Test Description',
        ]));
        $this->repositoryMock->shouldNotReceive('create', 'update', 'delete', 'setActive');
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json($method, $url, $data);
        $response->assertStatus(422);
        $response->assertJsonFragment($errors);
    }

    /**
     * Data provider for test_solution_create_and_update_validation_fails().
     * @return array
     */
    static function validationFailTestDataProvider(): array
    {
        $methodAndUrls = [
            'POST' => ['/solutions', false],
            'PUT' => ['/solutions/123456789', true],
        ];

        $dataAndErrors = [
            [
                ['POST', 'PUT'],
                [
                    'number' => '123456789',
                    'description' => 'Test Description',
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                ],
                ['title' => ['The title field is required.']]
            ],
            [
                ['POST'],
                [
                    'title' => 'Test Solution',
                    'description' => 'Test Description',
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,

                ],
                ['number' => ['The number field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'title' => 'Test Solution',
                    'number' => '123456789',
                    'description' => 'Test Description',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                ],
                ['category' => ['The category field is required.']]
            ],
            [
                ['POST', 'PUT'],
                [
                    'title' => 'Test Solution',
                    'number' => '123456789',
                    'description' => 2,
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,

                ],
                ['description' => ['The description field must be a string.']]
            ]
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
                if ($method === 'PUT') {
                    // remove number from data
                    unset($dataAndError[1]['number']);
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
     * Tests that validation passes when creating or updating solutions.
     * Using test data from validationPassTestDataProvider().
     * Tests that missing data that is not required (e.g. email and description) doesn't fail validation.
     *
     * @dataProvider validationPassTestDataProvider
     * @param string $url
     * @param bool $createFirst
     * @param string $method
     * @param array $data
     * @param array $methodNames
     * @param array|Solution $return
     * @return void
     */
    function test_solution_create_and_update_validation_passes(string         $url, bool $createFirst, string $method,
        array          $data, array $methodNames,
        array|Solution $return): void
    {
        $this->repositoryMock->shouldReceive('find')->andReturn(new Solution([
            'title' => 'Test Solution',
            'number' => 123456789,
            'category' => 'Product',
            'price_per_unit' => 100,
            'units' => 1,
            'vat_rate' => 0.20,
            'description' => 'Test Description',

        ]));
        $this->repositoryMock->shouldReceive(...$methodNames)->andReturn($return);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json($method, $url, $data);
        $response->assertStatus(302);
    }

    /**
     * Data provider for test_solution_create_and_update_validation_passes().
     * @return array
     */
    static function validationPassTestDataProvider(): array
    {
        $methodAndUrls = [
            'POST' => ['/solutions', false],
            'PUT' => ['/solutions/123456789', true],
        ];

        $dataAndErrors = [
            [
                ['POST', 'PUT'],
                [
                    'title' => 'Test Solution',
                    'number' => 123456789,
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                    'description' => 'Test Description',
                ],
                ['create', 'update'],
                new Solution([
                    'title' => 'Test Solution',
                    'number' => 123456789,
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                    'description' => 'Test Description',

                ]),
            ],
            [
                ['POST', 'PUT'],
                [
                    'title' => 'Test Solution',
                    'number' => '123456789',
                    //                    'description' => 'Test Description',
                    'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                ],
                ['create', 'update'],
                new Solution([
                    'title' => 'Test Solution',
                    'number' => '123456789',
                    'description' => 'Test Description',
                    // 'category' => 'Product',
                    'price_per_unit' => 100,
                    'units' => 1,
                    'vat_rate' => 0.20,
                ]),
            ],
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
                if ($method === 'PUT') {
                    // remove number from data
                    unset($dataAndError[1]['number']);
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
