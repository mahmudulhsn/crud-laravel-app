<?php

namespace App\Interfaces;

use App\Models\AddressBook;
use Illuminate\Database\Eloquent\Collection;

interface AddressBookRepositoryInterface
{
    /**
     * Return all AddressBooks
     *
     * @param array $relationship
     * @return Collection
     */
    public function getAllAddressBooks(?array $relationNames = []): Collection;

    /**
     * Create a new AddressBook
     *
     * @param array $addressBookDetails
     * @return AddressBook
     */
    public function createAddressBook(array $addressBookDetails): AddressBook;

    /**
     * Find AddressBook AddressBook by id and return AddressBook
     *
     * @param integer $addressBookID
     * @param array|null $relationNames
     * @return AddressBook
     */
    public function getAddressBookById(int $addressBookID, ?array $relationNames = []): AddressBook;

    /**
     * Update a a AddressBook
     *
     * @param object $addressBook
     * @param array $newDetails
     * @return boolean
     */
    public function updateAddressBook(object $addressBook, array $newDetails): bool;

    /**
     * Delete a AddressBook
     *
     * @param object $addressBook
     * @return boolean
     */
    public function deleteAddressBook(object $addressBook): bool;
}
