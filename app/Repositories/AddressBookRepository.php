<?php

namespace App\Repositories;

use App\Models\AddressBook;
use App\Interfaces\AddressBookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AddressBookRepository implements AddressBookRepositoryInterface
{

    /**
     * AddressBookRepository constructor.
     *
     * @param AddressBook $model
     */
    public function __construct(protected AddressBook $model)
    {
        $this->model = $model;
    }

    /**
     * Return all the AddressBook
     *
     * @param array|null $relationNames
     * @return Collection
     */
    public function getAllAddressBooks(?array $relationNames = []): Collection
    {
        $addressBook = $this->model->query();
        if ($relationNames !== []) {
            $addressBook->with($relationNames);
        }
        return $addressBook->oldest('name')->get();
    }

    /**
     * Create new AddressBook and return the AddressBook object
     *
     * @param array $addressBookDetails
     * @return AddressBook
     */
    public function createAddressBook(array $addressBookDetails): AddressBook
    {
        return $this->model->create($addressBookDetails);
    }

    /**
     * Find AddressBook by ID and return the AddressBook object
     *
     * @param integer $addressBookID
     * @param array|null $relationNames
     * @return AddressBook
     */
    public function getAddressBookById(int $addressBookID, ?array $relationNames = []): AddressBook
    {
        $addressBook = $this->model->query();
        if ($relationNames !== []) {
            $addressBook->with($relationNames);
        }

        return $addressBook->where('id', $addressBookID)->latest()->first();
    }

    /**
     * Update AddressBook
     *
     * @param object $addressBook
     * @param array $newDetails
     * @return boolean
     */
    public function updateAddressBook(object $addressBook, array $newDetails): bool
    {
        return $addressBook->update($newDetails);
    }

    /**
     * Delete a single AddressBook
     *
     * @param object $addressBook
     * @return boolean
     */
    public function deleteAddressBook(object $addressBook): bool
    {
        return $addressBook->delete();
    }
}
