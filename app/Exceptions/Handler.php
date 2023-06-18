<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if ($e instanceof TodoListServiceException) {
            $statusCode = 400;
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], $statusCode);
        }

        if ($e instanceof TodoListNotFoundException) {
            $statusCode = 404;
            $errorMessage = 'TodoList not found';
            return response()->json(['error' => $errorMessage], $statusCode);
        }

        if ($e instanceof TodoListNotEditableException) {
            $statusCode = 400;
            $errorMessage = 'TodoList is not editable';
            return response()->json(['error' => $errorMessage], $statusCode);
        }

        if ($e instanceof TodoListNotDeletableException) {
            $statusCode = 400;
            $errorMessage = 'TodoList is not deletable';
            return response()->json(['error' => $errorMessage], $statusCode);
        }

        return parent::render($request, $e);
    }
}
