<?php

namespace App\Interfaces;

interface CustomerSolutionRepositoryInterface
{
    /**
     * @param string $registration_number
     * @return paginated CustomerSolutions for Customer with specified registrations number
     */
    public function all(string $registration_number);

    /**
     * @param string $registration_number
     * @return mixed unpaginated CustomerSolutions for Customer with specified registrations number
     */
    public function allUnpaginated(string $registration_number);

    public function create(string $registration_number, array $data);

    public function find(string $registration_number, $id);

    public function update(string $registration_number, $id, array $data);

    public function delete(string $registration_number, $id);

}
