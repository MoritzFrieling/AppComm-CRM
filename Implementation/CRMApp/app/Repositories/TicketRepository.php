<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Ticket;
use GrahamCampbell\GitLab\GitLabManager;

class TicketRepository implements \App\Interfaces\TicketRepositoryInterface
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected GitLabManager $gitlab
    ) {
    }

    public function all(string $registration_number)
    {
        // TODO: Implement all() method.
    }

    public function create(string $registration_number, array $data)
    {
        $issue = $this->gitlab->issues()->create(
            $data['project_id'],
            array_merge($data, ['issue_type' => $data['category']])
        );
        $customer = $this->customerRepository->find($registration_number);
        return Ticket::query()->create([
            'customer_id' => $customer->id,
            'issue_id' => $issue['id'],
            'title' => $issue['title'],
        ]);
    }

    public function find(string $registration_number,$id)
    {
        // TODO: Implement find() method.
    }

    public function update(string $registration_number,$id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(string $registration_number,$id)
    {
        // TODO: Implement delete() method.
    }
}
