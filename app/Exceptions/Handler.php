<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

final class Handler extends ExceptionHandler
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
        $this->reportable(function (Throwable $e): void {

        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception, $request) {
             if ($request->expectsJson()) {
                return new JsonResponse(
                    ['error' => 'You are not authorized'],
                    Response::HTTP_UNAUTHORIZED
                );
             }
        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception, $request) {
             if ($request->expectsJson()) {
                return new JsonResponse(
                    ['error' => 'Resource Not Found'],
                    Response::HTTP_NOT_FOUND
                );
             }
        });
    }
}
