<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerSolutionRequest;
use App\Http\Requests\UpdateCustomerSolutionRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\CustomerSolutionRepositoryInterface;
use App\Interfaces\SolutionRepositoryInterface;
use App\Models\CustomerSolution;
use App\Models\Solution;
use Inertia\Inertia;

class CustomerSolutionController extends Controller
{


    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected CustomerSolutionRepositoryInterface $customerSolutionRepository,
        protected SolutionRepositoryInterface $solutionRepository
    ) {
    }

    /**
     * Would normally display a listing of the resource.
     * However, for customer solution this is done on the customer page.
     * Therefore, a 404 is returned.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $registration_number)
    {
        $customer = $this->customerRepository->find($registration_number);
        $solutions = $this->solutionRepository->allUnpaginated();
        return Inertia::render(
            'Customers/CustomerSolutions/Create',
            [
                'customer' => $customer,
                'solutions' => $solutions
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerSolutionRequest $request, string $registration_number)
    {
        $attributes = $request->validated();
        $customer_solution = $this->customerSolutionRepository->create($registration_number, $attributes);

        return redirect()->route('customers.show', ['customer' => $registration_number]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $registration_number, string $id)
    {
        $customer = $this->customerRepository->find($registration_number);
        $customerSolution = $this->customerSolutionRepository->find($registration_number, $id);
        $solution = $this->solutionRepository->findById($customerSolution->solution_id);
        return Inertia::render('Customers/CustomerSolutions/Show', [
            'customer' => $customer,
            'customer_solution' => $customerSolution,
            'solution' => $solution
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $registration_number, string $id)
    {
        $customer = $this->customerRepository->find($registration_number);
        $solutions = $this->solutionRepository->allUnpaginated();
        $customerSolution = $this->customerSolutionRepository->find($registration_number, $id);
        return Inertia::render(
            'Customers/CustomerSolutions/Edit',
            [
                'customer' => $customer,
                'solutions' => $solutions,
                'customer_solution' => $customerSolution
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerSolutionRequest $request, string $registration_number, string $id)
    {
        $attributes = $request->validated();
        $customerSolution = $this->customerSolutionRepository->update($registration_number, $id, $attributes);
        return redirect()->route(
            'customers.solutions.show',
            [
                'customer' => $registration_number,
                'solution' => $customerSolution->id
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $registration_number, string $id)
    {
        $this->customerSolutionRepository->delete($registration_number, $id);

        return redirect()->route('customers.show', $registration_number);
    }
}
