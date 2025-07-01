<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use App\Filters\BookFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->middleware('auth:api');
        $this->bookService = $bookService;
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Book::class);
        $books = (new BookFilter($request, Book::query()->with(['author', 'category'])))
            ->apply()
            ->paginate(10);

        return response()->json([
            'data' => BookResource::collection($books),
            'message' => 'Books retrieved successfully.',
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ],
        ], 200);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $this->authorize('create', Book::class);
        $book = $this->bookService->create($request->validated());

        return response()->json([
            'data' => new BookResource($book),
            'message' => 'Book created successfully.',
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $book = Book::with(['author', 'category'])->findOrFail($id);
        $this->authorize('view', $book);

        return response()->json([
            'data' => new BookResource($book),
            'message' => 'Book retrieved successfully.',
        ], 200);
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $this->authorize('update', $book);
        $book = $this->bookService->update($book, $request->validated());

        return response()->json([
            'data' => new BookResource($book),
            'message' => 'Book updated successfully.',
        ], 200);
    }

    public function destroy(Book $book): JsonResponse
    {
        $this->authorize('delete', $book);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.'], 204);
    }
}
