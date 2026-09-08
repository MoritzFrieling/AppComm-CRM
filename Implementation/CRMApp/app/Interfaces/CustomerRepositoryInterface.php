<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    public function all(string|null $search, array|null $filters);

    public function create(array $data);

    public function find($registration_number);

    public function update($registration_number, array $data);

    public function delete($registration_number);

    public function setActive($registration_number, bool $active);
}
