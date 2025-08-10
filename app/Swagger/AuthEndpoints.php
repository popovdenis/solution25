<?php

namespace App\Swagger;

/**
 * @OA\Post(
 *   path="/api/auth/register",
 *   tags={"Auth"},
 *   summary="Register new user",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"name","email","password"},
 *       @OA\Property(property="name", type="string", example="Denis"),
 *       @OA\Property(property="email", type="string", format="email", example="denis@example.com"),
 *       @OA\Property(property="password", type="string", format="password", example="secret123")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Created"),
 *   @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
 * )
 *
 * @OA\Post(
 *   path="/api/auth/login",
 *   tags={"Auth"},
 *   summary="Login",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="denis@example.com"),
 *       @OA\Property(property="password", type="string", format="password", example="secret123")
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="OK",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(property="access_token", type="string"),
 *       @OA\Property(property="token_type", type="string", example="bearer"),
 *       @OA\Property(property="expires_in", type="integer", example=3600)
 *     )
 *   ),
 *   @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Post(
 *   path="/api/auth/refresh",
 *   tags={"Auth"},
 *   summary="Refresh token",
 *   security={{"bearerAuth":{}}},
 *   @OA\Response(response=200, description="OK"),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 *
 * @OA\Post(
 *   path="/api/auth/logout",
 *   tags={"Auth"},
 *   summary="Logout",
 *   security={{"bearerAuth":{}}},
 *   @OA\Response(response=200, description="OK"),
 *   @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Message"))
 * )
 */
class AuthEndpoints {}
