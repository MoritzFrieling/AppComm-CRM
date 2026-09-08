<?php

namespace Feature;

use App\Models\ContactPerson;
use App\Models\Customer;
use App\Models\GitlabProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class GitlabProjectValidationTest extends TestCase
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
        $this->repositoryMock = $this->cmock('App\Interfaces\GitlabProjectRepositoryInterface');
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
    function test_contact_person_create_and_update_validation_fails(
        string $url,
        bool $createFirst,
        string $method,
        array $data,
        array $errors
    ): void {
//        $this->repositoryMock->shouldHaveReceived('find')->andReturn(
//            new ContactPerson(
//                [
//                    'first_name' => 'Test First Name',
//                    'last_name' => 'Test Last Name',
//                    'gender' => 'd',
//                    'email' => 'example@test.com',
//                    'phone_number' => '0612345678',
//                    'function' => 'Test Function',
//                ]
//            )
//        );
        $this->repositoryMock->shouldNotHaveBeenCalled();
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
            'POST' => ['/customers/123456789/gitlab_projects/', false],
        ];

        $dataAndErrors = [
            [
                ['POST'],
                [
                ],
                ['id' => ['The id field is required.']]
            ],
            [
                ['POST'],
                [
                    'id' => '1',
                    'customer_id' => '1',
                ],
                ['customer_id' => ['The customer id field must be missing.']]
            ],
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
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
     * @param GitlabProject $return
     * @return void
     */
    function test_customer_create_and_update_validation_passes(
        string $url,
        bool $createFirst,
        string $method,
        array $data,
        array $methodNames,
        GitlabProject $return
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
            'POST' => ['/customers/123456789/gitlab_projects', false],
        ];

        $dataAndErrors = [
            [
                ['POST'],
                [
                    'id' => '1',
                ],
                ['assign'],
                new GitlabProject(
                    [
                        'id' => '1',
                        'name' => 'Test Name',
                    ],
                ),
            ],
        ];

        $result = [];

        foreach ($dataAndErrors as $dataAndError) {
            foreach ($dataAndError[0] as $method) {
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
