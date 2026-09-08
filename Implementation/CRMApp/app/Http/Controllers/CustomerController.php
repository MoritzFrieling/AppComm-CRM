<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\CustomerSolutionRepositoryInterface;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\CustomerSolution;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{

    private CustomerRepositoryInterface $customerRepository;
    private CustomerSolutionRepositoryInterface $customerSolutionRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository,
        CustomerSolutionRepositoryInterface $customerSolutionRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->customerSolutionRepository = $customerSolutionRepository;
    }

    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filters = $request->input('filters');
        $customers = $this->customerRepository->all(search: $search, filters: $filters);
        return Inertia::render('Customers/Index', [
            'customers' => $customers,
            'filters' => $request->only(['search', 'filters']),
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $attributes = $request->validated();
        $customer = $this->customerRepository->create($attributes);

        return redirect()->route('customers.show', $customer->registration_number);
    }

    /**
     * Display the specified customer.
     */
    public function show(string $registration_number)
    {
        $customer = $this->customerRepository->find($registration_number);
        $customer_solutions = $this->customerSolutionRepository->allUnpaginated($registration_number);
        return Inertia::render('Customers/Show', [
            'customer' => $customer,
            'customer_solutions' => $customer_solutions
        ]);
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(string $registration_number)
    {
        $customer = $this->customerRepository->find($registration_number);
        return Inertia::render('Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpdateCustomerRequest $request, string $registration_number)
    {
        $attributes = $request->validated();
        $customer = $this->customerRepository->update($registration_number, $attributes);

        return redirect()->route('customers.show', $customer->registration_number);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(string $registration_number)
    {
        $customer = $this->customerRepository->delete($registration_number);

        return redirect()->route('customers.index');
    }

    /**
     * Activate or deactivate the specified customer in storage.
     */
    public function active(string $registration_number, string $active)
    {
        $active_bool = filter_var(
            $active,
            FILTER_VALIDATE_BOOLEAN
        );

        $customer = $this->customerRepository->setActive($registration_number, $active_bool);

        return redirect()->route('customers.show', $customer->registration_number);
    }
}
