<?php

namespace Tests\Feature;

use App\Interfaces\SolutionRepositoryInterface;
use App\Models\Solution;
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

class SolutionTest extends TestCase
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
     * Tests that the solution overview cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_solution_overview_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/solutions');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution create page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_solution_create_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/solutions/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution edit page cannot be rendered when unauthenticated.
     *
     * @return void
     */
    function test_solution_edit_cannot_be_rendered_when_unauthenticated(): void
    {
        $response = $this->get('/solutions/123456789/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution store endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_solution_store_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->post('/solutions');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution show endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_solution_show_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->get('/solutions/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution update endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_solution_update_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/solutions/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution destroy endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    function test_solution_destroy_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->delete('/solutions/123456789');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the solution activate endpoint cannot be accessed when unauthenticated.
     *
     * @return void
     */
    /*
    function test_solution_activate_cannot_be_accessed_when_unauthenticated(): void
    {
        $response = $this->put('/solutions/123456789/active/true');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    */
    /**
     * Tests that the solution overview page can be rendered when authenticated.
     *
     * @return void
     */
    function test_solution_overview_can_be_rendered_when_authenticated(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/solutions');

        $response->assertStatus(200);
    }

    /**
     * Tests that the solution create page can be rendered when authenticated.
     *
     * @return void
     */
    function test_solution_create_can_be_rendered_when_authenticated(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/solutions/create');

        $response->assertStatus(200);
    }

    /**
     * Tests that the solution show page can be rendered when authenticated.
     *
     * @return void
     */
    function test_solution_show_can_be_rendered_when_authenticated(): void
    {
        $number = $this->faker->randomNumber(9, true);
        Solution::factory()->create([
            'title' => 'Test Solution',
            'number' => 123456789,
            'category' => 'Product',
            'price_per_unit' => 100.0,
            'units' => 1,
            'vat_rate' => 0.20,
            'description' => 'Test Description',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/solutions/123456789');

        $response->assertStatus(200);
    }

    /**
     * Tests that the solution edit page can be rendered when authenticated.
     *
     * @return void
     */
    function test_solution_edit_can_be_rendered_when_authenticated(): void
    {
        $number = $this->faker->randomNumber(9, true);
        $solution = Solution::factory()->create([
            'title' => 'Test Solution',
            'number' => "$number",
            'category' => 'Product',
            'price_per_unit' => 100.0,
            'units' => 1,
            'vat_rate' => 0.20,
            'description' => 'Test Description',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/solutions/$solution->number/edit");

        $response->assertStatus(200);
    }

    /**
     * Tests that the solution store endpoint can be accessed when authenticated and a solution can be created.
     *
     * @return void
     */
    function test_solution_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $number = $this->faker->randomNumber(9, true);
        $response = $this->post('/solutions', [
            'title' => 'Test Solution',
            'number' => "$number",
            'category' => 'Product',
            'price_per_unit' => 100.0,
            'units' => 1,
            'vat_rate' => 0.20,
            'description' => 'Test Description',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('solutions.show', $number));
    }

    /**
     * Tests that the solution delete endpoint can be accessed when authenticated and a solution can be deleted.
     *
     * @return void
     */
    function test_solution_can_be_deleted(): void
    {
        $number = $this->faker->randomNumber(9, true);
        $solution = Solution::factory()->create([
            'title' => 'Test Solution',
            'number' => "$number",
            'category' => 'Product',
            'price_per_unit' => 100.0,
            'units' => 1,
            'vat_rate' => 0.20,
            'description' => 'Test Description',
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('solutions.destroy', $solution->number));

        $response->assertStatus(302);
        $response->assertRedirect(route('solutions.index'));
    }

    /**
     * Tests that the solution activate endpoint can be accessed when authenticated and a solution can be activated.
     *
     * @return void
     */
    /*
    function test_solution_can_be_activated(): void
    {
        $solution = Solution::factory()->create([
            'number' => $this->faker->randomNumber(9, true),
            'active' => false,
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('solutions.active',
            ['number' => $solution->number, 'active' => 'true']));

        $response->assertStatus(302);
        $response->assertRedirect(route('solutions.show', $solution->number));
        $this->assertTrue($solution->refresh()->active);
    }

    /**
     * Tests that the solution deactivate endpoint can be accessed when authenticated and a solution can be deactivated.
     *
     * @return void

    function test_solution_can_be_deactivated(): void
    {
        $solution = Solution::factory()->create([
            'number' => $this->faker->randomNumber(9, true),
            'active' => true,
        ]);
        $solution->save();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('solutions.active',
            ['number' => $solution->number, 'active' => 'false']));

        $response->assertStatus(302);
        $response->assertRedirect(route('solutions.show', $solution->number));
        $this->assertFalse($solution->refresh()->active);
    }
    */
    private
    function paginate($items, $perPage = 5, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
