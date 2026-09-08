<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactPersonRequest;
use App\Http\Requests\UpdateContactPersonRequest;
use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;

class ContactPersonController extends Controller
{

    public function __construct(
        protected ContactPersonRepositoryInterface $contactPersonRepository,
        protected CustomerRepositoryInterface $customerRepository
    ) {
    }

    /**
     * Would normally display a listing of the resource.
     * However, for contact persons this is done on the customer page.
     * Therefore, a 404 is returned.
     */
    public function index(string $registration_number)
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $registration_number)
    {
        $customer = $this->customerRepository->find($registration_number);
        return Inertia::render(
            'Customers/ContactPersons/Create',
            [
                'customer' => $customer
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactPersonRequest $request, string $registration_number)
    {
        $attributes = $request->validated();
        $contact_person = $this->contactPersonRepository->create($registration_number, $attributes);

        return redirect()->route('customers.show', ['customer' => $registration_number]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $registration_number, string $id)
    {
        $customer = $this->customerRepository->find($registration_number);
        $contactPerson = $this->contactPersonRepository->find($registration_number, $id);
        return Inertia::render('Customers/ContactPersons/Show', [
            'customer' => $customer,
            'contact_person' => $contactPerson
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $registration_number, string $id)
    {
        $contact_person = $this->contactPersonRepository->find($registration_number, $id);
        return Inertia::render(
            'Customers/ContactPersons/Edit',
            [
                'contact_person' => $contact_person
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactPersonRequest $request, string $registration_number, string $id)
    {
        $attributes = $request->validated();
        $contact_person = $this->contactPersonRepository->update($registration_number, $id, $attributes);

        return redirect()->route(
            'customers.contact_persons.show',
            ['customer' => $registration_number, 'contact_person' => $contact_person->id]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $registration_number, string $id)
    {
        $this->contactPersonRepository->delete($registration_number, $id);

        return redirect()->route('customers.show', $registration_number);
    }
}
