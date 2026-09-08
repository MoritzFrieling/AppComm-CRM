<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\CustomerSolution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\TextUI\CliArguments\Builder;

class CustomerSolutionRepository implements \App\Interfaces\CustomerSolutionRepositoryInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function all(string $registration_number): LengthAwarePaginator
    {
        return CustomerSolution::query()->whereRelation(
            'customer',
            'registration_number',
            '=',
            $registration_number
        )->paginate(config('app.pagination_size'));
    }

    public function allUnpaginated(string $registration_number)
    {
        return CustomerSolution::query()->whereRelation(
            'customer',
            'registration_number',
            '=',
            $registration_number
        )->with('customer')->with('solution')->get();
    }

    public function create(string $registration_number, array $data)
    {
        $customer = $this->customerRepository->find($registration_number);
        return $customer->customer_solutions()->save(new CustomerSolution($data));
    }

    public function find(string $registration_number, $id): Model|Builder|CustomerSolution
    {
        return CustomerSolution::query()->where('id', $id)->whereRelation(
            'customer',
            'registration_number',
            $registration_number
        )->with('customer')->with('solution')->firstOrFail();
    }

    public function update(string $registration_number, $id, array $data)
    {
        $customerSolution = $this->find($registration_number, $id);
        $customerSolution->update($data);
        return $customerSolution;
    }

    public function delete(string $registration_number, $id)
    {
        $customerSolution = $this->find($registration_number, $id);
        $customerSolution->delete();
    }
}
