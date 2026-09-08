<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function all(string|null $search, array|null $filters): LengthAwarePaginator
    {
        $builder = Customer::query();
        if (!is_null($filters)) {
            foreach ($filters as $filter) {
                // check if array is not empty
                if (empty($filter) || !isset($filter['type']) || !isset($filter['operator']) || !isset($filter['value'])) {
                    continue;
                }
                $value = $filter['value'];
                $operator = $filter['operator'];
                $property = $filter['type']['property'];
                if ($operator === 'ilike' || $operator === 'not ilike') {
                    $property = "lower($property)";
                    $operator = str_replace('ilike', 'like', $operator);
                    $value = strtolower($value);
                }
                if ($operator === 'like' || $operator === 'not like') {
                    $value = "%$value%";
                }
                $builder = $builder->where($property, $operator, $value);
            }
        }
        return $builder
            ->when($search, function ($query, $search) {
                $query
                    ->where(DB::raw('lower(customer_name)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(registration_number)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(vat_number)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(email)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(website)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(address_street)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(address_house_number)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(address_postal_code)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(address_city)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(address_country)'), 'like', strtolower("%$search%"));
            })
            ->paginate(config('app.pagination_size'))
            ->withQueryString();
    }

    public function create(array $data): Model|Builder|Customer
    {
        return Customer::query()->create($data);
    }

    public function update($registration_number, array $data): Model|Customer|Builder
    {
        $customer = $this->find($registration_number);
        $customer->update($data);
        return $customer;
    }

    public function find($registration_number): Model|Customer|Builder
    {
        return Customer::query()->where('registration_number', $registration_number)->with(
            ['contact_persons', 'gitlab_projects', 'tickets']
        )->firstOrFail();
    }

    public function delete($registration_number): void
    {
        $customer = $this->find($registration_number);
        $customer->delete();
    }

    public function setActive($registration_number, bool $active): Model|Customer|Builder
    {
        $customer = $this->find($registration_number);
        $customer->active = $active;
        $customer->save();
        return $customer;
    }
}
