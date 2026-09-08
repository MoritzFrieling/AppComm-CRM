<?php

namespace App\Interfaces;

interface SolutionRepositoryInterface
{
    public function all(string|null $search, array|null $filters);

    public function create(array $data);

    public function find($number);

    public function update($number, array $data);

    public function delete($number);

    public function allUnpaginated();

    public function findById($id);

    /*
    public function setActive($number, bool $active);
    */
}

