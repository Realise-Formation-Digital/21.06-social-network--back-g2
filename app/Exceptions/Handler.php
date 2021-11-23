<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof ValidateException) {
                return response()->json([
                    'status_code' => 400,
                    'message' => json_decode($e->getMessage())
                ]);
//                return $this->failure(json_decode($e->getMessage()), $e->getCode() ?: 400);
            }
            if ($e instanceof UnauthorizedException) {
                return response()->json([
                    'status_code' => 400,
                    'message' => "Il y a eu une erreur de permission"
                ]);
//                return $this->failure('You do not have required authorization.', 403);
            }
            if ($e instanceof ApiException) {
                return response()->json([
                    'status_code' => 400,
                    'message' => $e->getMessage()
                ]);
//                return $this->failure('You do not have required authorization.', 403);
            }
            return response()->json([
                'status_code' => 500,
                'message' => "There was an error in the application"
            ]);
//        return $this->failure('There was an error in the application.', 500);
            // $this->failure($e->getTraceAsString(), $e->getCode() && is_numeric($e->getCode()) && $this->is_valid_http_status($e->getCode()) ? $e->getCode() : 400);
        });
    }
}
