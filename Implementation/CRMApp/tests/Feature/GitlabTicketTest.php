<?php

namespace Feature;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\ContactPersonRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\GitlabProjectRepository;
use Gitlab\Api\Issues;
use Gitlab\Api\Projects;
use GrahamCampbell\GitLab\GitLabManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class GitlabTicketTest extends TestCase
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
    private mixed $gitlabTicketRepository;

    /**
     * @var GitLabManager
     */
    private mixed $gitlabManagerMock;

    /**
     * @var Issues
     */
    private mixed $gitlabIssuesApiMock;

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
        $this->gitlabIssuesApiMock = $this->cmock('Gitlab\Api\Issues');
        $this->gitlabTicketRepository = $this->app->make(
            'App\Repositories\TicketRepository',
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
    function test_ticket_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/tickets/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_ticket_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/tickets/1/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_ticket_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/customers/123456789/tickets');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_ticket_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/tickets/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_ticket_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789/tickets/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_ticket_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/customers/123456789/tickets/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person index page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_ticket_index_cannot_be_accessed_when_unauthenticated(): void {
        $response = $this->get('/customers/123456789/tickets');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person index page throws 404 when authenticated.
     *
     * @return void
     */
    function test_ticket_index_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/customers/123456789/tickets');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person update endpoint throws 404 when authenticated.
     *
     * @return void
     */
    function test_ticket_update_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->put('/customers/123456789/tickets/1');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person show endpoint throws 404 when authenticated.
     *
     * @return void
     */
    function test_ticket_show_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/customers/123456789/tickets/1');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person edit endpoint throws 404 when authenticated.
     *
     * @return void
     */
    function test_ticket_edit_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/customers/123456789/tickets/1/edit');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person delete endpoint throws 404 when authenticated.
     *
     * @return void
     */
    function test_ticket_delete_throws_404_when_authenticated(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->delete('/customers/123456789/tickets/1');

        $response->assertStatus(404);
    }

    /**
     * Tests that the contact person create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_ticket_create_can_be_rendered_when_authenticated(): void
    {
        $this->gitlabManagerMock->shouldReceive('projects')->andReturn($this->gitlabIssuesApiMock);
        $this->gitlabIssuesApiMock->shouldReceive('all')->andReturn([
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

        $response = $this->get(route('customers.tickets.create', ['customer' => $registration_number]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person edit page can be rendered when authenticated.
     *
     * @return void
     */
/*    function test_ticket_edit_can_be_rendered_when_authenticated(): void
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
        $ticket = $this->gitlabProjectRepository->assign(
            $registration_number,
            '1'
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.tickets.edit',
                ['customer' => $registration_number, 'ticket' => $ticket->id]
            )
        );

        $response->assertStatus(200);
    }*/

    /**
     * Tests that the contact person show page can be rendered when authenticated.
     *
     * @return void
     */
/*    function test_ticket_show_can_be_rendered_when_authenticated(): void
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
        $ticket = $this->gitlabProjectRepository->assign(
            $registration_number,
            '1'
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.tickets.show',
                ['customer' => $registration_number, 'ticket' => $ticket->id]
            )
        );

        $response->assertStatus(200);
    }*/

    /**
     * Tests that the contact person store endpoint can be accessed when authenticated and a contact person can be created.
     *
     * @return void
     */
    function test_ticket_can_be_created(): void
    {
        $this->gitlabManagerMock->shouldReceive('issues')->andReturn($this->gitlabIssuesApiMock);
        $this->gitlabIssuesApiMock->shouldReceive('create')->andReturn([
            'id' => '1',
            'title' => 'Test Ticket',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $response = $this->post(route('customers.tickets.store', ["customer" => $registration_number]), [
            'project_id' => '1',
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category' => 'issue'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $registration_number));
    }

    /**
     * Tests that the contact person delete endpoint can be accessed when authenticated and a contact person can be deleted.
     *
     * @return void
     */
/*    function test_ticket_can_be_deleted(): void
    {
        $this->gitlabManagerMock->shouldReceive('issues')->andReturn($this->gitlabIssuesApiMock);
        $this->gitlabIssuesApiMock->shouldReceive('create')->andReturn([
            'id' => '1',
            'title' => 'Test Ticket',
        ]);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $ticket = $this->gitlabTicketRepository->create(
            $registration_number,
            [
                'project_id' => '1',
                'title' => 'Test Ticket',
                'description' => 'Test Description',
                'category' => 'issue'
            ]
        );
        dump($ticket);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(
            route(
                'customers.tickets.destroy',
                ['customer' => $registration_number, 'ticket' => $ticket]
            )
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', ['customer' => $registration_number]));
    }*/

}
