<?php

namespace App\Http\Controllers;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\GitlabProjectRepositoryInterface;
use App\Models\GitlabProject;
use App\Http\Requests\StoreGitlabProjectRequest;
use App\Http\Requests\UpdateGitlabProjectRequest;
use GrahamCampbell\GitLab\GitLabManager;
use Inertia\Inertia;

class GitlabProjectController extends Controller
{

    public function __construct(
        protected GitLabManager $gitlab,
        protected GitlabProjectRepositoryInterface $gitlabProjectRepository,
        protected CustomerRepositoryInterface $customerRepository
    ) {
    }

    /**
     * Display a listing of the resource.
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
        $gitlab_projects = $this->gitlabProjectRepository->allProjects();
        return Inertia::render(
            'Customers/GitlabProjects/Create',
            [
                'customer' => $customer,
                'gitlab_projects' => $gitlab_projects
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGitlabProjectRequest $request, string $registration_number)
    {
        $attributes = $request->validated();
        $gitlab_project = $this->gitlabProjectRepository->assign($registration_number, $attributes['id']);

        return redirect()->route('customers.show', ['customer' => $registration_number]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $registration_number, string $id)
    {
        $customer = $this->customerRepository->find($registration_number);
        $gitlab_project = $this->gitlabProjectRepository->find($registration_number, $id);
        return Inertia::render(
            'Customers/GitlabProjects/Show',
            [
                'gitlab_project' => $gitlab_project,
                'customer' => $customer
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $registration_number, string $id)
    {
        $customer = $this->customerRepository->find($registration_number);
        $gitlab_project = $this->gitlabProjectRepository->find($registration_number, $id);
        return Inertia::render(
            'Customers/GitlabProjects/Edit',
            [
                'gitlab_project' => $gitlab_project,
                'customer' => $customer
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $registration_number, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $registration_number, string $id)
    {
        $this->gitlabProjectRepository->unassign($registration_number, $id);
        return redirect()->route('customers.show', ['customer' => $registration_number]);
    }
}
