<?php

namespace App\Interfaces;

interface GitlabProjectRepositoryInterface
{
    public function allProjects(): array;
    public function all(string $registration_number);

    public function find(string $registration_number, $id);

    /**
     * Assign a GitlabProject to a Customer
     *
     * @param string $registration_number
     * @param int|string $id The id of the GitlabProject (Not the internal id but the one from Gitlab)
     */
    public function assign(string $registration_number, int|string $id);

    /**
     * Unassign a GitlabProject from a Customer
     *
     * @param string $registration_number
     * @param int|string $id The id of the GitlabProject (Not the internal id but the one from Gitlab)
     */
    public function unassign(string $registration_number, $id);
}
