<?php

namespace App\Repositories;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\ContactPerson;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\TextUI\CliArguments\Builder;

class ContactPersonRepository implements ContactPersonRepositoryInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param string $registration_number
     * @return LengthAwarePaginator paginated ContactPersons for specified customer by registration number
     */
    public function all(string $registration_number): LengthAwarePaginator
    {
        return ContactPerson::query()->whereRelation('customer', 'registration_number', '=', $registration_number)->paginate(config('app.pagination_size'));
    }

    /**
     * adds a contact person the specified customer
     * @param string $registration_number customer identifier
     * @param array $data contact person data
     * @return Model|Builder|ContactPerson
     */
    public function create(string $registration_number, array $data): Model|Builder|ContactPerson
    {
        $customer = $this->customerRepository->find($registration_number);
        return $customer->contact_persons()->save(new ContactPerson($data));
    }


    /**
     * retrieves a contact person with specific id for an specific customer
     * @param string $registration_number registration number of the customer
     * @param $id String id of contact perosn
     * @return Model|Builder|ContactPerson
     */
    public function find(string $registration_number, $id): Model|Builder|ContactPerson
    {
        return ContactPerson::query()->where('id', $id)->with('customer')->firstOrFail();
    }


    /**
     * updates a specific contact person for a specific customer
     * @param string $registration_number
     * @param $id String id of contact person
     * @param array $data updated contact person
     * @return Model|Builder|ContactPerson
     */
    public function update(string $registration_number, $id, array $data): Model|Builder|ContactPerson
    {
        $contactPerson = $this->find($registration_number, $id);
        $contactPerson->update($data);
        return $contactPerson;
    }

    /**
     * removes a specific contact person from a custoemr
     * @param string $registration_number registration number of customer
     * @param $id String id of contact person
     */
    public function delete(string $registration_number, $id): void
    {
        $contactPerson = $this->find($registration_number, $id);
        $contactPerson->delete();
    }
}
