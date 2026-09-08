<?php

namespace Tests\Feature;

use App\Interfaces\customerSolutionRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\customerSolutionRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\SolutionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class CustomerSolutionTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * @var CustomerRepository
     */
    private mixed $customerRepository;

    /**
     * @var SolutionRepository
     */
    private mixed $solutionRepository;

    /**
     * @var customerSolutionRepository
     */
    private mixed $customerSolutionRepository;

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
        $this->solutionRepository = $this->app->make('App\Repositories\SolutionRepository');
        $this->customerSolutionRepository = $this->app->make('App\Repositories\CustomerSolutionRepository');
    }

    /**
     * Tests that the contact person create page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/solutions/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/solutions/1/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/customers/123456789/solutions');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/solutions/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789/solutions/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_solution_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/customers/123456789/solutions/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_solution_create_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('customers.solutions.create', ['customer' => $registration_number]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person show page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_solution_show_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $number = $this->faker->randomNumber(9, true);
        $solution = $this->solutionRepository->create(
            [
                'title' => 'Test Solution',
                'number' => "$number",
                'category' => 'Product',
                'description' => 'Test Description',
                'price_per_unit' => '99.99',
                'units' => '5',
                'vat_rate' => '0.19'
            ]
        );
        $customer_solution = $this->customerSolutionRepository->create(
            $registration_number,
            [
                'solution_id' => $solution->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'units' => '1',
                'price_per_unit' => '29.99',
                'recurring_period' => '1',
                'recurring_period_unit' => 'month',
                'vat_rate' => '0.07',
                'description' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.solutions.show',
                ['customer' => $registration_number, 'solution' => $customer_solution->id]
            )
        );

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person edit page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_solution_edit_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $number = $this->faker->randomNumber(9, true);
        $solution = $this->solutionRepository->create(
            [
                'title' => 'Test Solution',
                'number' => "$number",
                'category' => 'Product',
                'description' => 'Test Description',
                'price_per_unit' => '99.99',
                'units' => '5',
                'vat_rate' => '0.19'
            ]
        );
        $customer_solution = $this->customerSolutionRepository->create(
            $registration_number,
            [
                'solution_id' => $solution->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'units' => '1',
                'price_per_unit' => '29.99',
                'recurring_period' => '1',
                'recurring_period_unit' => 'month',
                'vat_rate' => '0.07',
                'description' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(
            route(
                'customers.solutions.edit',
                ['customer' => $registration_number, 'solution' => $customer_solution->id]
            )
        );

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person store endpoint can be accessed when authenticated and a contact person can be created.
     *
     * @return void
     */
    function test_customer_solution_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $number = $this->faker->randomNumber(9, true);
        $solution = $this->solutionRepository->create(
            [
                'title' => 'Test Solution',
                'number' => "$number",
                'category' => 'Product',
                'description' => 'Test Description',
                'price_per_unit' => '99.99',
                'units' => '5',
                'vat_rate' => '0.19'
            ]
        );
        $response = $this->post(route('customers.solutions.store', ["customer" => $registration_number]), [
            'solution_id' => $solution->id,
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
            'units' => '1',
            'price_per_unit' => '29.99',
            'recurring_period' => '1',
            'recurring_period_unit' => 'month',
            'vat_rate' => '0.07',
            'description' => ''
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $registration_number));
    }

    /**
     * Tests that the contact person delete endpoint can be accessed when authenticated and a contact person can be deleted.
     *
     * @return void
     */
    function test_customer_solution_can_be_deleted(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $number = $this->faker->randomNumber(9, true);

        $solution = $this->solutionRepository->create(
            [
                'title' => 'Test Solution',
                'number' => "$number",
                'category' => 'Product',
                'description' => 'Test Description',
                'price_per_unit' => '99.99',
                'units' => '5',
                'vat_rate' => '0.19'
            ]
        );
        $customer_solution = $this->customerSolutionRepository->create(
            $registration_number,
            [
                'solution_id' => $solution->id,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'units' => '1',
                'price_per_unit' => '29.99',
                'recurring_period' => '1',
                'recurring_period_unit' => 'month',
                'vat_rate' => '0.07',
                'description' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(
            route(
                'customers.solutions.destroy',
                ['customer' => $registration_number, 'solution' => $customer_solution->id]
            )
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', ['customer' => $registration_number]));
    }

}
