<?php

namespace App\Swagger;

/**
 * @OA\Get(
 *   path="/api/me/books",
 *   tags={"User Library"},
 *   summary="List books linked to current user",
 *   security={{"bearerAuth":{}}},
 *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BookCollection")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Get(
 *   path="/api/me/books/available",
 *   tags={"User Library"},
 *   summary="List books available to link (exclude already linked)",
 *   security={{"bearerAuth":{}}},
 *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/BookCollection")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Post(
 *   path="/api/me/books",
 *   tags={"User Library"},
 *   summary="Link a book to current user",
 *   security={{"bearerAuth":{}}},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"book_id"},
 *       @OA\Property(property="book_id", type="integer", example=10)
 *     )
 *   ),
 *   @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/BookResource")),
 *   @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError")),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Delete(
 *   path="/api/me/books/{book}",
 *   tags={"User Library"},
 *   summary="Unlink a book from current user",
 *   security={{"bearerAuth":{}}},
 *   @OA\Parameter(name="book", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\Response(response=204, description="No Content"),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 */
class UserLibraryEndpoints {}
