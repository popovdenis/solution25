<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *   title="Books Management API",
 *   version="1.0.0",
 *   description="REST API for managing books with JWT auth. Includes owner CRUD and user-library bindings."
 * )
 *
 * @OA\Server(
 *   url="/",
 *   description="Local server"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 *
 * @OA\Tag(name="Auth", description="Authentication endpoints")
 * @OA\Tag(name="Books", description="Owner's books (1:N)")
 * @OA\Tag(name="User Library", description="User ↔ Books bindings (many-to-many)")
 */
class OpenApi {}
