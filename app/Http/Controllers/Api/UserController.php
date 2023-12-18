<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;
use App\Interfaces\UserRepositoryInterface;

class UserController extends ApiController
{

    /**
     * userController Constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers([]);
        return $this->sendResponse('All users.', ['users' => UserResource::collection($users)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request)
    {
        $userInfo = $request->validated();
        $user = $this->userRepository->createUser($userInfo);

        return $this->sendResponse('user has been created.', ['user' => new UserResource($user)], 201);
    }

    /**
     * Show single user
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->getUserById($id, []);
        return $this->sendResponse('Single user', ['user' => new UserResource($user)], 200);
    }

    /**
     * Update resource
     * @return JsonResponse
     */
    public function update(string $id, UserRequest $request): JsonResponse
    {
        $userInfo = $request->validated();

        $user = $this->userRepository->getUserById($id, []);

        if ($user instanceof User) {
            $this->userRepository->updateUser($user, $userInfo);

        }
        return $this->sendResponse('user has been  Updated.', ['user' => new UserResource($user)], 201);
    }

    /**
     * Remove resource
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $user = $this->userRepository->getUserById($id, []);
        if ($user instanceof User) {

            $this->userRepository->deleteUser($user);
        }
        return $this->sendResponse('user has been Deleted.', [], 200);
    }
}
