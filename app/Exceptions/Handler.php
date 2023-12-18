<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof ValidationException) {
            $statusCode = 422;
            $message = $exception->getMessage();
            $errors = $exception->errors();
        } elseif ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $message =
                $statusCode == 404 ? "Not Found!" : $exception->getMessage();
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = 401;
            $message =
                App::environment("production") && $exception->getCode() == 500
                ? "Something Went Wrong!"
                : $exception->getMessage();
        } else {
            if ($exception instanceof QueryException) {
                DB::rollback();
            }

            $statusCode =
                $exception->getCode() >= 400 && $exception->getCode() <= 499
                ? $exception->getCode()
                : 500;
            $message =
                App::environment("production") && $exception->getCode() == 500
                ? "Something Went Wrong!"
                : $exception->getMessage();
        }

        return response()->json([
            "success" => false,
            "statusCode" => $statusCode,
            "message" => $message,
            "errors" => isset($errors) ? $errors : [],
        ], $statusCode);
    }
}
