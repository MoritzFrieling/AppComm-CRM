<?php

namespace App\Repositories;

use App\Interfaces\SolutionRepositoryInterface;
use App\Models\Solution;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolutionRepository implements SolutionRepositoryInterface
{

    public function all(string|null $search, array|null $filters): LengthAwarePaginator
    {
        $builder = Solution::query();
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
                    ->where(DB::raw('lower(title)'), 'like', strtolower("%$search%"))
                    ->orWhere('number', 'like', "%$search%")
                    ->orWhere(DB::raw('lower(category)'), 'like', strtolower("%$search%"))
                    ->orWhere(DB::raw('lower(description)'), 'like', strtolower("%$search%"));
            })
            ->paginate(config('app.pagination_size'))
            ->withQueryString();
    }

    public function create(array $data): Model|Builder|Solution
    {
        return Solution::query()->create($data);
    }


    public function find($number): Model|Solution|Builder
    {
        return Solution::query()->where('number', $number)->firstOrFail();
    }

    public function findById($id): Model|Solution|Builder
    {
        return Solution::query()->where('id', $id)->firstOrFail();
    }


    public function update($number, array $data): Model|Solution|Builder
    {
        $solution = $this->find($number);
        $solution->update($data);
        return $solution;
    }

    public function delete($number): void
    {
        $solution = $this->find($number);
        $solution->delete();
    }

    public function allUnpaginated()
    {
        return Solution::query()->get();
    }

}

