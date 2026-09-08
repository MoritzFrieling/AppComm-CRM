<?php

namespace tests\Feature;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\ContactPersonRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ContactPersonTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * @var CustomerRepository
     */
    private mixed $customerRepository;

    /**
     * @var ContactPersonRepository
     */
    private mixed $contactPersonRepository;

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
        $this->contactPersonRepository = $this->app->make('App\Repositories\ContactPersonRepository');
    }

    /**
     * Tests that the contact person create page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/contact_persons/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/contact_persons/1/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/customers/123456789/contact_persons');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/customers/123456789/contact_persons/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/customers/123456789/contact_persons/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_contact_person_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/customers/123456789/contact_persons/1');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the contact person create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_contact_person_create_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('customers.contact_persons.create', ['customer' => $registration_number]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person show page can be rendered when authenticated.
     *
     * @return void
     */
    function test_contact_person_show_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $contact_person = $this->contactPersonRepository->create(
            $registration_number,
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('customers.contact_persons.show', ['customer' => $registration_number, 'contact_person' => $contact_person->id]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person edit page can be rendered when authenticated.
     *
     * @return void
     */
    function test_contact_person_edit_can_be_rendered_when_authenticated(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $contact_person = $this->contactPersonRepository->create(
            $registration_number,
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('customers.contact_persons.edit', ['customer' => $registration_number, 'contact_person' => $contact_person->id]));

        $response->assertStatus(200);
    }

    /**
     * Tests that the contact person store endpoint can be accessed when authenticated and a contact person can be created.
     *
     * @return void
     */
    function test_contact_person_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $response = $this->post(route('customers.contact_persons.store', ["customer"=> $registration_number]), [
            'gender' => 'm',
            'first_name' => 'Max',
            'middle_name' => '',
            'last_name' => 'Mustermann',
            'email' => 'max@mustermann.de',
            'phone_number' => '',
            'function' => 'CTO'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', $registration_number));
    }

    /**
     * Tests that the contact person delete endpoint can be accessed when authenticated and a contact person can be deleted.
     *
     * @return void
     */
    function test_contact_person_can_be_deleted(): void
    {
        $registration_number = $this->faker->randomNumber(9, true);
        $this->customerRepository->create(
            [
                'registration_number' => $registration_number,
            ]
        );
        $contact_person = $this->contactPersonRepository->create(
            $registration_number,
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => ''
            ]
        );
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('customers.contact_persons.destroy', ['customer' => $registration_number, 'contact_person' => $contact_person->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.show', ['customer' => $registration_number]));
    }

}
