<?php

namespace App\Swagger;

/**
 * @OA\Info(title="Books API", version="1.0.0")
 * @OA\Server(url="/")
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
class OpenApi {}
