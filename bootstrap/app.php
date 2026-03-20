<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Constants\HttpStatusCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php',

    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            /*
            |--------------------------------------------------------------------------
            | API Exception Handling
            |--------------------------------------------------------------------------
            */
            if ($request->expectsJson() || $request->is('api/*')) {
                $status = match (true) {

                    $e instanceof ValidationException => HttpStatusCode::UNPROCESSABLE_ENTITY, // Validation errors (422)
                    $e instanceof AuthenticationException => HttpStatusCode::UNAUTHORIZED,  // Authentication error (401)
                    $e instanceof AuthorizationException => HttpStatusCode::FORBIDDEN,  // Authorization error (403)
                    $e instanceof ModelNotFoundException => HttpStatusCode::NOT_FOUND, // Model not found (404)
                    $e instanceof QueryException => HttpStatusCode::INTERNAL_SERVER_ERROR, // General server error (500)
                    $e instanceof BadMethodCallException => HttpStatusCode::INTERNAL_SERVER_ERROR,
                    $e instanceof HttpExceptionInterface => $e->getStatusCode(),  // HTTP exceptions (404,405 etc)
                    default => HttpStatusCode::INTERNAL_SERVER_ERROR
                };

                $data = [
                    'request_id'       => Str::uuid()->toString(),
                    'api_version'      => config('app.app_version'),
                    'frontend_version' => $request->server('HTTP_FRONTEND_VERSION'),
                    'url_path'         => $request->fullUrl(),
                    'method'           => $request->method(),
                    // 'user_id'          => JWTAuth::id() ?? 0,
                    'user_id'          => auth()->id() ?? 0,
                    'ip_address'       => $request->ip() ?? 'UNKNOWN',
                    'called_on'        => now()->format('Y-m-d H:i:s'),
                    'response_code'    => $status,
                    'country'          => $request->header('cf-ipcountry') ?? 'UNKNOWN',
                    'city'             => $request->header('cf-ipcity') ?? 'UNKNOWN',
                    'state'            => $request->header('cf-region') ?? 'UNKNOWN',
                    'json_data'        => json_encode($request->input()), // $request->except(['password','token'])
                    'response_data'    => json_encode([
                        'exception' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->take(5)->toArray(),
                    ]),
                ];
                Log::error('API Exception', $data);

                return response()->json([
                    'status' => false,
                    'code' => $status,
                    'message' => $e->getMessage() ?: 'Server Error',
                ], $status);
            }
        });
    })->create();
