<?php

namespace App\Interfaces;

interface ContactPersonRepositoryInterface
{

    /**
     * @param string $registration_number
     * @return mixed paginated ContactPersons for specified customer by registration number
     */
    public function all(string $registration_number);

    /**
     * adds a contact person the specified customer
     * @param string $registration_number customer identifier
     * @param array $data contact person data
     * @return mixed
     */
    public function create(string $registration_number, array $data);

    /**
     * retrieves a contact person with specific id for an specific customer
     * @param string $registration_number registration number of the customer
     * @param $id String id of contact person
     * @return mixed
     */
    public function find(string $registration_number, $id);

    /**
     * updates a specific contact person for a specific customer
     * @param string $registration_number
     * @param $id
     * @param array $data updated contact person
     * @return mixed
     */
    public function update(string $registration_number, $id, array $data);

    /**
     * removes a specific contact person from a custoemr
     * @param string $registration_number registration number of customer
     * @param $id String id of contact person
     * @return mixed
     */
    public function delete(string $registration_number, $id);

}
