<?php
namespace App\Http\Controllers;

use App\Http\Requests\PaginatedRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * Class BookController
 * @package  App\Http\Controllers
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *  operationId="indexBook",
     *  path="/books",
     *  security={ { "BearerAuth": {} } },
     *  tags={"Books"},
     *  summary="Get list of Book",
     *  description="Returns list of Book",
     *  @OA\Parameter(ref="#/components/parameters/page"),
     *  @OA\Parameter(ref="#/components/parameters/per_page"),
     *  @OA\Response(response=200, description="Successful operation",
     *    @OA\JsonContent(ref="#/components/schemas/BooksPaginated"),
     *  ),
     * )
     *
     * Display a listing of Book.
     * @return JsonResponse
     */
    public function index(PaginatedRequest $request)
    {
        $validated = $request->validated();
        $query = Book::query();
        $result = $query->paginate($validated['per_page']);
        $pagesCount = $result->lastPage();

        if ($validated['page'] > $pagesCount) {
            throw ValidationException::withMessages(['page' => "Page Out of Range"]);
        }

        return response()->json($result);
    }

    /**
     * @OA\Post(
     *  operationId="storeBook",
     *  path="/books",
     *  security={ { "BearerAuth": {} } },
     *  summary="Insert a new Book",
     *  description="Insert a new Book",
     *  tags={"Books"},
     *  @OA\RequestBody(
     *    description="Book to create",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      ref="#/components/schemas/Book"
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="Book created",
     *     @OA\JsonContent(ref="#/components/schemas/Book"),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        $input = $request->validated();
        $data = Book::create($input);
        return response()->json($data, RESPONSE::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *   path="/books/{book_id}",
     *   summary="Show a Book from his Id",
     *   description="Show a Book from his Id",
     *   security={ { "BearerAuth": {} } },
     *   operationId="showBook",
     *   tags={"Books"},
     *   @OA\Parameter(ref="#/components/parameters/Book--id"),
     *   @OA\Response(response=200,description="Successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Book"),
     *   ),
     *   @OA\Response(response="404",description="Book not found"),
     * )
     *
     * @param Book $Book
     * @return JsonResponse
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    /**
     * @OA\Patch(
     *   operationId="updateBook",
     *   summary="Update an existing Book",
     *   description="Update an existing Book",
     *   security={ { "BearerAuth": {} } },
     *   tags={"Books"},
     *   path="/books/{book_id}",
     *   @OA\Parameter(ref="#/components/parameters/Book--id"),
     *   @OA\Response(response="204",description="No content"),
     *   @OA\RequestBody(
     *     description="Book to update",
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(ref="#/components/schemas/Book")
     *     )
     *   )
     * )
     *
     * @param Request $request
     * @param Book $Book
     * @return Response|JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->noContent();
    }

    /**
     * @OA\Delete(
     *  path="/books/{book_id}",
     *  summary="Delete a Book",
     *  description="Delete a Book",
     *  security={ { "BearerAuth": {} } },
     *  operationId="destroyBook",
     *  tags={"Books"},
     *  @OA\Parameter(ref="#/components/parameters/Book--id"),
     *  @OA\Response(response=204,description="No content"),
     *  @OA\Response(response=404,description="Book not found"),
     * )
     *
     * @param Book $Book
     * @return Response|JsonResponse
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
