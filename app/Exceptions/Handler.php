<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     */
    protected $levels = [];

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function render($request, Throwable $exception)
    {
        $exception = $this->normalizeException($exception);

        // Handle HTTP exceptions (404, 403, etc.)
        if ($exception instanceof HttpExceptionInterface) {
            return $this->renderHttpException($exception);
        }

        // Handle all other exceptions as 500 (server error)
        return $this->renderGenericException($exception);
    }

    /**
     * Render HTTP exceptions with custom error pages.
     */
    protected function renderHttpException(HttpExceptionInterface $exception)
    {
        $statusCode = $exception->getStatusCode();

        $errorData = ErrorConfiguration::getErrorData($statusCode);

        $view = $errorData['view'] ?? ErrorConfiguration::getErrorView();

        return response()->view($view, [
            'statusCode' => $statusCode,
            'title' => $errorData['title'],
            'message' => $errorData['message'],
            'image' => $errorData['image'],
            'exception' => $exception,
        ], $statusCode);
    }

    /**
     * Render generic exceptions (non-HTTP) as 500 errors.
     */
    protected function renderGenericException(Throwable $exception)
    {
        $statusCode = 500;

        $errorData = ErrorConfiguration::getErrorData($statusCode);

        $view = $errorData['view'] ?? ErrorConfiguration::getErrorView();

        return response()->view($view, [
            'statusCode' => $statusCode,
            'title' => $errorData['title'],
            'message' => $errorData['message'],
            'image' => $errorData['image'],
            'exception' => $exception,
        ], $statusCode);
    }

    /**
     * Normalize exceptions for consistent handling.
     */
    private function normalizeException(Throwable $exception): Throwable
    {
        if ($exception instanceof AuthorizationException) {
            return new HttpException(403, $exception->getMessage(), $exception);
        }

        return $exception;
    }
}
