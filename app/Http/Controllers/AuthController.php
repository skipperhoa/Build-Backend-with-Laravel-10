<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'checkToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = Auth::guard('api')->attempt($credentials);
        // Log::info("message",[$token]);
        Log::withContext(['request' => Auth::guard('api')->user()]);
        if (! $token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /* register */
    public function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = Auth::guard('api')->login($user);

        return response()->json([
            'user' => $user,
            'status' => 'success',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',

            ]
        ]);
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


    public function checkToken()
    {

        try {
            // ✅ Lấy token từ header
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json([
                    'status' => -2,
                    'message' => 'Không có token trong request.'
                ], 401);
            }

            // ✅ Parse token để lấy payload
            $payload = JWTAuth::setToken($token)->getPayload();

            // ✅ Kiểm tra thời gian hết hạn
            $exp = $payload->get('exp');
            $now = time();

            if ($now >= $exp) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Token đã hết hạn.'
                ], 401);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Token còn hạn và hợp lệ.'
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 0, 'message' => 'Token đã hết hạn.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => -1, 'message' => 'Token không hợp lệ.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => -2, 'message' => 'Không có token hoặc token lỗi.'], 401);
        }
    }
}
