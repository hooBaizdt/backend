<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // jwt 找不到已经登陆的用户 或者 框架默认的授权认证失败(没有通过 auth:api 中间件检查)
        /** @see \Tymon\JWTAuth\JWTGuard::userOrFail */
        /** @see \Illuminate\Auth\Middleware\Authenticate::authenticate */
        if ($exception instanceof \Tymon\JWTAuth\Exceptions\UserNotDefinedException ||
            $exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'code' => env('STATUS_CODE_NOT_LOGIN'),
                'message' => '未登录'
            ]);
        }

        return parent::render($request, $exception);
    }


}
