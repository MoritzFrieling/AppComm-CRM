<?php

namespace Feature;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\ContactPersonRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\GitlabProjectRepository;
use GrahamCampbell\GitLab\GitLabManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class GitlabProjectTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * @var CustomerRepository
     */
    private mixed $customerRepository;

    /**
     * @var GitlabProjectRepository
     */
    private mixed $gitlabProjectRepository;#

    /**
     * @var GitLabManager
     */
    private mixed $gitlabManagerMock;

    private int $registration_number;

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->customerRepository = $this->app->make('App\Repositories\CustomerRepository');
        $this->gitlabManagerMock = $this->cmock('GrahamCampbell\GitLab\GitLabManager');
        $this->gitlabProjectsApiMock = $this->cmock('Gitlab\Api\Projects');
        $this->gitlabProjectRepository = $this->app->make(
            'App\Repositories\GitlabProjectRepository',
            [$this->customerRepository, $this->gitlabManagerMock]
        );
    }

    public function cmock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Tests that the contact person create page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/gitlab_projects/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/gitlab_projects/1/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/customers/123456789/gitlab_projects');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/gitlab_projects/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789/gitlab_projects/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/customers/123456789/gitlab_projects/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person index page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_gitlab_project_index_cannot_be_accessed_when_unauthenticated(): void {
        $response = $this->get('/customers/123456789/gitlab_projects');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person index page throws 404 when authenticated.
     *
     * @return void
     */
    function test_gitlab_project_index_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/customers/123456789/gitlab_projects');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person update endpoint throws 404 when authenticated.
     *
     * @return void
     */
    function test_gitlab_project_update_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->put('/customers/123456789/gitlab_projects/1');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_gitlab_project_create_can_be_rendered_when_authenticated(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabProjectsApiMock);
        $this->gitlabProjectsApiMock->shouldReceive('all')->andReturn([
            [
                'id' => '1',
                'name' => 'Test Project',
            ],
        ]);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('customers.gitlab_projects.create', ['customer' => $registration_number]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person edit page can be rendered when authenticated.
     *
     * @return void
     */
    function test_gitlab_project_edit_can_be_rendered_when_authenticated(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabProjectsApiMock);
        $this->gitlabProjectsApiMock->shouldReceive('show')->andReturn([
            'id' => '1',
            'name' => 'Test Project',
        ]);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $gitlab_project = $this->gitlabProjectRepository->assign(
            $registration_number,
            '1'
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.gitlab_projects.edit',
                ['customer' => $registration_number, 'gitlab_project' => $gitlab_project->id]
            )
        );

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person show page can be rendered when authenticated.
     *
     * @return void
     */
    function test_gitlab_project_show_can_be_rendered_when_authenticated(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabProjectsApiMock);
        $this->gitlabProjectsApiMock->shouldReceive('show')->andReturn([
            'id' => '1',
            'name' => 'Test Project',
        ]);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $gitlab_project = $this->gitlabProjectRepository->assign(
            $registration_number,
            '1'
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.gitlab_projects.show',
                ['customer' => $registration_number, 'gitlab_project' => $gitlab_project->id]
            )
        );

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person store endpoint can be accessed when authenticated and a contact person can be created.
     *
     * @return void
     */
    function test_gitlab_project_can_be_created(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabProjectsApiMock);
        $this->gitlabProjectsApiMock->shouldReceive('show')->andReturn([
            'id' => '1',
            'name' => 'Test Project',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $response = $this->post(route('customers.gitlab_projects.store', ["customer" => $registration_number]), [
            'id' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $registration_number));
    }

    /**
     * Tests that the contact person delete endpoint can be accessed when authenticated and a contact person can be deleted.
     *
     * @return void
     */
    function test_gitlab_project_can_be_deleted(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabProjectsApiMock);
        $this->gitlabProjectsApiMock->shouldReceive('show')->andReturn([
            'id' => '1',
            'name' => 'Test Project',
        ]);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $gitlab_project = $this->gitlabProjectRepository->assign(
            $registration_number,
            'id'
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(
            route(
                'customers.gitlab_projects.destroy',
                ['customer' => $registration_number, 'gitlab_project' => $gitlab_project->id]
            )
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', ['customer' => $registration_number]));
    }

}
