<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\GitlabProjectRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use GrahamCampbell\GitLab\Facades\GitLab;
use GrahamCampbell\GitLab\GitLabManager;
use Inertia\Inertia;

class TicketController extends Controller
{

    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected TicketRepositoryInterface $ticketRepository,
        protected GitlabProjectRepositoryInterface $gitlabProjectRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $registration_number, StoreTicketRequest $request)
    {
        $attributes = $request->validated();
        $this->ticketRepository->create($registration_number, $attributes);
        return redirect()->route('customers.show', ['customer' => $registration_number]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $registration_number)
    {
        $customer = $this->customerRepository->find($registration_number);
        $projects = $this->gitlabProjectRepository->all($registration_number);
        return Inertia::render('Customers/Tickets/Create', [
            'customer' => $customer,
            'projects' => $projects,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ticket)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ticket)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, string $ticket)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticket)
    {
        abort(404);
    }
}
