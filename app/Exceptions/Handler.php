<?php

namespace App\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Throwable;

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            // Customize the validation response format
            return response()->json(
                [
                    'success' => false, 
                    'errors' => $exception->errors(),
                    'token' => $request->bearerToken(),
                    'data' => [],
                    'message' => 'Validation Failed'
                ], 
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        }

        return parent::render($request, $exception);
    }
}
