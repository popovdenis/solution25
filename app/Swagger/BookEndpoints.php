<?php

namespace App\Swagger;

/**
 * @OA\Get(
 *   path="/api/books",
 *   tags={"Books"},
 *   summary="List my books",
 *   security={{"bearerAuth":{}}},
 *   @OA\Parameter(name="q", in="query", @OA\Schema(type="string"), description="Search by title/author"),
 *   @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", minimum=1, maximum=100), example=10),
 *   @OA\Parameter(name="sort", in="query", @OA\Schema(type="string"), example="title,-publication_year"),
 *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BookCollection")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Post(
 *   path="/api/books",
 *   tags={"Books"},
 *   summary="Create a book",
 *   security={{"bearerAuth":{}}},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="multipart/form-data",
 *       @OA\Schema(
 *         required={"title","author","publication_year"},
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="author", type="string"),
 *         @OA\Property(property="publication_year", type="integer", minimum=1),
 *         @OA\Property(property="cover", type="string", format="binary")
 *       )
 *     )
 *   ),
 *   @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/BookResource")),
 *   @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Get(
 *   path="/api/books/{book}",
 *   tags={"Books"},
 *   summary="Show my book",
 *   security={{"bearerAuth":{}}},
 *   @OA\Parameter(name="book", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BookResource")),
 *   @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/Message")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Put(
 *   path="/api/books/{book}",
 *   tags={"Books"},
 *   summary="Update my book",
 *   security={{"bearerAuth":{}}},
 *   @OA\Parameter(name="book", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(property="title", type="string"),
 *       @OA\Property(property="author", type="string"),
 *       @OA\Property(property="publication_year", type="integer", minimum=1)
 *     )
 *   ),
 *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BookResource")),
 *   @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError")),
 *   @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Delete(
 *   path="/api/books/{book}",
 *   tags={"Books"},
 *   summary="Delete my book",
 *   security={{"bearerAuth":{}}},
 *   @OA\Parameter(name="book", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\Response(response=204, description="No Content"),
 *   @OA\Response(response=404, description="Not Found", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 */
class BookEndpoints {}
