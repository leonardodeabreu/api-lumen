<?php

declare(strict_types=1);

namespace App\Api\Users\Controllers;

use App\Api\Users\DTO\UserDTO;
use App\Api\Users\Interfaces\UserRepositoryInterface;
use App\Api\Users\Resources\UserResource;
use App\Api\Users\Resources\UserWithBooksResource;
use App\Base\Validations\Rules\Lowercase;
use App\Base\Validations\Rules\Unique;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /** @var UserRepositoryInterface $repository */
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /** @throws ValidationException */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->validate($request, [
            'name'   => 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:11',
            'age'    => 'nullable|integer',
            'email'  => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        try {
            return UserResource::collection($this->repository->findWhere(
                UserDTO::fromArray($request->all())
            ));
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function show(int $id): UserWithBooksResource
    {
        try {
            return new UserWithBooksResource($this->repository->findByID($id));
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /** @throws ValidationException */
    public function store(Request $request): UserResource
    {
        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:11',
            'age'      => 'required|integer',
            'active'   => 'required|boolean',
            'password' => 'required|string',
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                new Lowercase,
                new Unique('users', null, null, ['deleted_at'], null),
            ],
        ]);

        try {
            return new UserResource($this->repository->create(
                $request->only($request->keys())
            ));
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /** @throws ValidationException */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:11',
            'age'      => 'required|integer',
            'active'   => 'required|boolean',
            'password' => 'required|string',
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                new Lowercase,
                new Unique('users', null, null, ['deleted_at'], ['id' => $id]),
            ],
        ]);

        try {
            $this->repository->update($request->only($request->keys()), $id);

            return $this->responseMessage('User updated successfully.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $loggedUserId = $request->auth->id;
        if ($id === $loggedUserId) {
            abort(401, trans('Unauthorized delete logged user.'));
        }

        try {
            if ($this->repository->delete($id)) {
                return $this->responseMessage('User deleted successfully.');
            }

            return $this->responseMessage('Failed to deleted user.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
