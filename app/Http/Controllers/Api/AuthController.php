<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

/**
 * Class AuthController
 * @package App\Http\Controllers
 *
 * 授权请求：
 * 1、添加 Authorization header
 *  Authorization: Bearer eyJhbGciOiJIUzI1NiI...（Bearer + 空格 + access_token）
 * 2、添加 Query string parameter
 *  http://example.dev/me?token=eyJhbGciOiJIUzI1NiI... （参数名为 token）
 *
 * 示例：
 * curl -X POST \
 *      http://localhost:5700/api/auth/me \
 *      -H 'Authorization: Bearer eyJ0eXAiOiJKV1Q...'
 *
 * curl -X POST \
 *      'http://localhost:5700/api/auth/me?token=eyJ0eXAiOiJKV1...'
 *
 * 有个要注意的地方：5.5 中路由 routes/api.php 中的路由需要加上前缀 'api' 来访问
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 单点登陆支持, 只保存一个 access_token, 如果可以多个设备登陆则不需要
        $previous_token = \Cache::tags('tokens')->get(request('email'));
        if ($previous_token) {
            try {
                \JWTAuth::setToken($previous_token)->invalidate();
            } catch (\Exception $exception) {
            }
        }
        \Cache::tags('tokens')->forever(request('email'), $token);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}