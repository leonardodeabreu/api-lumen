<?php

declare(strict_types=1);

namespace App\Api\Books\Controllers;

use App\Api\Books\DTO\BookDTO;
use App\Api\Books\Interfaces\BookRepositoryInterface;
use App\Api\Books\Resources\BookResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /** @var BookRepositoryInterface */
    protected $repository;

    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /** @throws ValidationException */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->validate($request, [
            'title'    => 'nullable|string|max:255',
            'isbn'     => 'nullable|string|max:13',
            'category' => 'nullable|string|max:100',
            'year'     => 'nullable|integer',
        ]);

        try {
            return BookResource::collection($this->repository->findWhere(
                BookDTO::fromArray($request->all())
            ));
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function show(int $id): BookResource
    {
        try {
            return new BookResource($this->repository->findByID($id));
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /** @throws ValidationException */
    public function store(Request $request): BookResource
    {
        $this->validate($request, [
            'title'    => 'required|string|max:255',
            'isbn'     => 'required|string|max:13',
            'category' => 'required|string|max:100',
            'year'     => 'required|integer',
        ]);

        try {
            return new BookResource($this->repository->create(
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
            'title'    => 'required|string|max:255',
            'isbn'     => 'required|string|max:13',
            'category' => 'required|string|max:100',
            'year'     => 'required|integer',
        ]);

        try {
            $this->repository->update($request->only($request->keys()), $id);

            return $this->responseMessage('Book updated successfully.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            if ($this->repository->delete($id)) {
                return $this->responseMessage('Book deleted successfully.');
            }

            return $this->responseMessage('Failed to deleted book.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /** @throws ValidationException */
    public function saveFavorite(Request $request): JsonResponse
    {
        $this->validate($request, [
            'book_id' => 'required|integer|exists:books,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        try {
            $this->repository->saveFavorites($request->get('user_id'), $request->get('book_id'));

            return $this->responseMessage('Book favorited successfully.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /** @throws ValidationException */
    public function removeFavorite(Request $request): JsonResponse
    {
        $this->validate($request, [
            'book_id' => 'required|integer|exists:books,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        try {
            $this->repository->removeFavorites($request->get('user_id'), $request->get('book_id'));

            return $this->responseMessage('Book removed from favorite successfully.');
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
