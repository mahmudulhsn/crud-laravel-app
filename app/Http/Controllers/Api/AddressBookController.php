<?php

namespace App\Http\Controllers\Api;


use App\Models\AddressBook;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AddressBookRequest;
use App\Http\Resources\AddressBookResource;
use App\Interfaces\AddressBookRepositoryInterface;

class AddressBookController extends ApiController
{
    /**
     * AddressBookController Constructor
     *
     * @param AddressBookRepositoryInterface $addressBookRepository
     */
    public function __construct(
        protected AddressBookRepositoryInterface $addressBookRepository,
    ) {
        $this->addressBookRepository = $addressBookRepository;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $addressBooks = $this->addressBookRepository->getAllAddressBooks(['user']);
        return $this->sendResponse('All AddressBooks.', ['addressBooks' => AddressBookResource::collection($addressBooks)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(AddressBookRequest $request)
    {
        $addressBookInfo = $request->validated();
        $addressBook = $this->addressBookRepository->createAddressBook($addressBookInfo);

        return $this->sendResponse('AddressBook has been created.', ['addressBook' => new AddressBookResource($addressBook)], 201);
    }

    /**
     * Show single AddressBook
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $addressBook = $this->addressBookRepository->getAddressBookById($id, ['user']);
        return $this->sendResponse('Single AddressBook', ['addressBook' => new AddressBookResource($addressBook)], 200);
    }

    /**
     * Update resource
     * @return JsonResponse
     */
    public function update(string $id, AddressBookRequest $request): JsonResponse
    {
        $addressBookInfo = $request->validated();

        $addressBook = $this->addressBookRepository->getAddressBookById($id, []);

        if ($addressBook instanceof AddressBook) {
            $this->addressBookRepository->updateAddressBook($addressBook, $addressBookInfo);

        }
        return $this->sendResponse('Address Book has been  Updated.', ['addressBook' => new AddressBookResource($addressBook)], 201);
    }

    /**
     * Remove resource
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $addressBook = $this->addressBookRepository->getAddressBookById($id, []);
        if ($addressBook instanceof AddressBook) {

            $this->addressBookRepository->deleteAddressBook($addressBook);
        }
        return $this->sendResponse('Address Book has been Deleted.', [], 200);
    }
}
