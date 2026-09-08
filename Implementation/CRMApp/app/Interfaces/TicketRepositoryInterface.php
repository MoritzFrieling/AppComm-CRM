<?php

namespace App\Interfaces;

interface TicketRepositoryInterface
{
    public function all(string $registration_number);

    public function create(string $registration_number, array $data);

    public function find(string $registration_number, $id);

    public function update(string $registration_number, $id, array $data);

    public function delete(string $registration_number, $id);

}
