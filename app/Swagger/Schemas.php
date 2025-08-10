<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *   schema="Book",
 *   type="object",
 *   required={"id","title","author","publication_year"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="title", type="string", example="The Great Gatsby"),
 *   @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
 *   @OA\Property(property="publication_year", type="integer", example=1925),
 *   @OA\Property(property="cover_url", type="string", nullable=true, example="http://127.0.0.1:8000/storage/covers/xyz.webp"),
 *   @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-10T08:00:00Z"),
 *   @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-10T08:10:00Z")
 * )
 *
 * @OA\Schema(
 *   schema="BookResource",
 *   type="object",
 *   @OA\Property(property="data", ref="#/components/schemas/Book")
 * )
 *
 * @OA\Schema(
 *   schema="BookCollection",
 *   type="object",
 *   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Book")),
 *   @OA\Property(
 *     property="links",
 *     type="object",
 *     @OA\Property(property="first", type="string"),
 *     @OA\Property(property="last", type="string"),
 *     @OA\Property(property="prev", type="string", nullable=true),
 *     @OA\Property(property="next", type="string", nullable=true)
 *   ),
 *   @OA\Property(
 *     property="meta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=3),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="to", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=25)
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="ValidationError",
 *   type="object",
 *   @OA\Property(property="message", type="string", example="Validation error"),
 *   @OA\Property(property="errors", type="object",
 *     example={"title":{"The title field is required."}}
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Message",
 *   type="object",
 *   @OA\Property(property="message", type="string", example="Unauthenticated")
 * )
 */
class Schemas {}
