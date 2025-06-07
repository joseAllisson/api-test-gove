<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    // web: __DIR__.'/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    //
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->renderable(function (ValidationException $e, $request) {
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors(),
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    $exceptions->renderable(function (\InvalidArgumentException $e, $request) {
      return response()->json([
        'message' => 'Invalid request',
        'error' => $e->getMessage()
      ], Response::HTTP_BAD_REQUEST);
    });

    // Tratamento para outras exceções
    $exceptions->renderable(function (\Exception $e, $request) {
      Log::error('Error: ' . $e->getMessage());

      return response()->json([
        'message' => 'Internal Server Error',
        'error' => env('APP_DEBUG') ? $e->getMessage() : 'Something went wrong',
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    });
  })->create();
