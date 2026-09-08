<?php

namespace App\Http\Controllers;

use App\Interfaces\SolutionRepositoryInterface;
use App\Models\Solution;
use App\Http\Requests\StoreSolutionRequest;
use App\Http\Requests\UpdateSolutionRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SolutionController extends Controller
{

    private SolutionRepositoryInterface $solutionRepository;

    public function __construct(SolutionRepositoryInterface $solutionRepository)
    {
        $this->solutionRepository = $solutionRepository;
    }

    /**
     * Display a listing of the solutions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filters = $request->input('filters');
        $solutions = $this->solutionRepository->all($search, $filters);

        return Inertia::render('Solutions/Index', [
            'solutions' => $solutions,
            'filters' => $request->only(['search', 'filters']),
        ]);
    }

    /**
     * Show the form for creating a new solution.
     */
    public function create()
    {
        return Inertia::render('Solutions/Create');
    }

    /**
     * Store a newly created solution in storage.
     */
    public function store(StoreSolutionRequest $request)
    {
        $attributes = $request->validated();
        $solution = $this->solutionRepository->create($attributes);

        return redirect()->route('solutions.show', ['solution' => $solution->number]);
    }

    /**
     * Display the specified solution.
     */
    public function show(string $number)
    {
        $solution = $this->solutionRepository->find($number);
        return Inertia::render('Solutions/Show', [
            'solution' => $solution,
        ]);
    }

    /**
     * Show the form for editing the specified solution.
     */
    public function edit(string $number)
    {
        $solution = $this->solutionRepository->find($number);
        return Inertia::render('Solutions/Edit', [
            'solution' => $solution,
        ]);
    }

    /**
     * Update the specified solution in storage.
     */
    public function update(UpdateSolutionRequest $request, string $number)
    {
        $attributes = $request->validated();
        $solution = $this->solutionRepository->update($number, $attributes);

        return redirect()->route('solutions.show', ['solution' => $solution->number]);
    }

    /**
     * Remove the specified solution from storage.
     */
    public function destroy(string $number)
    {
        $solution = $this->solutionRepository->delete($number);

        return redirect()->route('solutions.index');
    }

    /**
     * Activate or deactivate the specified solution in storage.
     * public function active(string $number, string $active)
     * {
     * $active_bool = filter_var(
     * $active,
     * FILTER_VALIDATE_BOOLEAN
     * );
     *
     * $solution = $this->solutionRepository->setActive($number, $active_bool);
     *
     * return redirect()->route('solutions.show', $solution->number);
     * }
     */

}

