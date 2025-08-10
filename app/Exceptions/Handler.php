<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(['message'=>'Validation error','errors'=>$e->errors()],422);
            }
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json(['message'=>'Unauthenticated'],401);
            }
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
                || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json(['message'=>'Not Found'],404);
            }
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                return response()->json(
                    ['message'=>$e->getMessage() ?: 'HTTP error'],
                    $e->getStatusCode()
                );
            }
            return response()->json(['message'=>'Server Error'],500);
        }

        // for non-API requests
        return parent::render($request, $e);
    }
}
