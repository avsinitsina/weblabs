<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson())
            {
                return response()->json([
                    "success"   => false,
                    "message"   => "Method's not allowed (Can't be matched to URI)"
                ], 400);
            }
            else
            {
                abort(400);
            }
        });
        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->isMethod('GET')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        "success" => false,
                        "message" => "Method's not allowed (Permission to view denied)"
                    ], 403);
                } else {
                    abort(403);
                }
            }
            else {
                if ($request->expectsJson()) {
                    return response()->json([
                        "success" => false,
                        "message" => "Method's not allowed (Permission denied)"
                    ], 405);
                } else {
                    abort(405);
                }
            }
        });
    }
}
