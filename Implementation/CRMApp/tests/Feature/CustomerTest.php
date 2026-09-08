<?php

namespace Tests\Feature;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\ContactPerson;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia as Assert;
use Throwable;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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
     * Tests that the customer overview cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_customer_overview_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer create page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_customer_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_customer_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/customers');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/customers/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer activate endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_customer_activate_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789/active/true');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the customer overview page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_overview_can_be_rendered_when_authenticated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/customers');

        $response->assertStatus(200);
    }

    /**
     * Tests that the customer create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_create_can_be_rendered_when_authenticated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/customers/create');

        $response->assertStatus(200);
    }

    /**
     * Tests that the customer show page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_show_can_be_rendered_when_authenticated(): void
    {
        Customer::factory()->create([
            'registration_number' => '123456789',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/customers/123456789');

        $response->assertStatus(200);
    }

    /**
     * Tests that the customer edit page can be rendered when authenticated.
     *
     * @return void
     */
    function test_customer_edit_can_be_rendered_when_authenticated(): void
    {
        $customer = Customer::factory()->create([
            'registration_number' => $this->faker->randomNumber(9, true),
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/customers/$customer->registration_number/edit");

        $response->assertStatus(200);
    }

    /**
     * Tests that the customer store endpoint can be accessed when authenticated and a customer can be created.
     *
     * @return void
     */
    function test_customer_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $registration_number = $this->faker->randomNumber(9, true);
        $response = $this->post('/customers', [
            'customer_name' => 'Test Customer',
            'registration_number' => "$registration_number",
            'vat_number' => '987654321',
            'email' => 'example@test.com',
            'website' => 'https://example.com',
            'address_street' => 'Test Street',
            'address_house_number' => '1',
            'address_postal_code' => '1234 AB',
            'address_city' => 'Test City',
            'address_country' => 'Test Country',
            'address_additional_information' => 'Test Additional Information',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $registration_number));
    }

    /**
     * Tests that the customer delete endpoint can be accessed when authenticated and a customer can be deleted.
     *
     * @return void
     */
    function test_customer_can_be_deleted(): void
    {
        $customer = Customer::factory()->create([
            'registration_number' => $this->faker->randomNumber(9, true),
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('customers.destroy', $customer->registration_number));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.index'));
    }

    /**
     * Test that a customer can be deleted when contact persons for that customer exist.
     *
     * @return void
     */
    function test_customer_can_be_deleted_contact_persons()
    {
        $customer = Customer::factory()->create([
            'registration_number' => $this->faker->randomNumber(9, true),
        ]);
        $contact_person = ContactPerson::factory()->create([
            'first_name' => 'Test Contact Person',
            'last_name' => 'Test Contact Person',
            'customer_id' => $customer->id,
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('customers.destroy', $customer->registration_number));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.index'));
    }

    /**
     * Tests that the customer activate endpoint can be accessed when authenticated and a customer can be activated.
     *
     * @return void
     */
    function test_customer_can_be_activated(): void
    {
        $customer = Customer::factory()->create([
            'registration_number' => $this->faker->randomNumber(9, true),
            'active' => false,
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(
            route(
                'customers.active',
                ['registration_number' => $customer->registration_number, 'active' => 'true']
            )
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $customer->registration_number));
        $this->assertTrue($customer->refresh()->active);
    }

    /**
     * Tests that the customer deactivate endpoint can be accessed when authenticated and a customer can be deactivated.
     *
     * @return void
     */
    function test_customer_can_be_deactivated(): void
    {
        $customer = Customer::factory()->create([
            'registration_number' => $this->faker->randomNumber(9, true),
            'active' => true,
        ]);
        $customer->save();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(
            route(
                'customers.active',
                ['registration_number' => $customer->registration_number, 'active' => 'false']
            )
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $customer->registration_number));
        $this->assertFalse($customer->refresh()->active);
    }

    private
    function paginate(
        $items,
        $perPage = 5,
        $page = null,
        $options = []
    ): LengthAwarePaginator {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
