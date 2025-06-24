<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
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


    /**
     * Показать список ресурсов.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Book::class);

        try {
            $books = Book::with(['author', 'category'])
                ->when($request->query('title'), fn($query, $title) => $query->where('title', 'like', "%{$title}%"))
                ->when($request->query('author_id'), fn($query, $authorId) => $query->where('author_id', $authorId))
                ->when($request->query('category_id'), fn($query, $categoryId) => $query->where('category_id', $categoryId))
                ->paginate(10);

            return response()->json([
                'data' => BookResource::collection($books),
                'meta' => [
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'per_page' => $books->perPage(),
                    'total' => $books->total(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось получить список книг.'], 500);
        }
    }

    /**
     * Сохранить новый ресурс.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $this->authorize('create', Book::class);

        try {
            $book = $this->bookService->create($request->validated());
            return response()->json([
                'data' => new BookResource($book->load(['author', 'category'])),
                'message' => 'Книга успешно создана.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Показать указанный ресурс.
     */
    public function show(Book $book): JsonResponse
    {
        $this->authorize('view', $book);

        try {
            return response()->json([
                'data' => new BookResource($book->load(['author', 'category'])),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось получить книгу.'], 500);
        }
    }

    /**
     * Обновить указанный ресурс.
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $this->authorize('update', $book);

        try {
            $book = $this->bookService->update($book, $request->validated());
            return response()->json([
                'data' => new BookResource($book->load(['author', 'category'])),
                'message' => 'Книга успешно обновлена.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Удалить указанный ресурс.
     */
    public function destroy(Book $book): JsonResponse
    {
        $this->authorize('delete', $book);

        try {
            $book->delete();
            return response()->json(['message' => 'Книга успешно удалена.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось удалить книгу.'], 500);
        }
    }
}
