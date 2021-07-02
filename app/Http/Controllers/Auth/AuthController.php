<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Constants;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

/**
 * @group Auth
 *
 * APIs for managing Authentication
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
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    /**
     * Login. Get a JWT via given credentials.
     *
     * @transformer  \App\Transformers\UserTransformer
     * 
     * @bodyParam email required string 
     * @bodyParam password required string 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        return $this->respondWithToken($token, $user);
    }

    /**
     * Get the authenticated User.
     *
     * @transformer  \App\Transformers\UserTransformer
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Register a User.
     * 
     * @transformer  \App\Transformers\UserTransformer
     * 
     * @param SignUpRequest $request
     * @param JWTAuth $JWTAuth
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(SignupRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User();
        $user->fill($request->all());
        $user->profile_id = Profile::where('name', Constants::PROFILE_USER)->first()->id;
        $user->save();

        $token = $JWTAuth->fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user->transform(),
            'token' => $token
        ], 201);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     * 
     * @response  {
     *  "access_token": JWT Token,
     *  "token_type": "bearer token",
     *  "user": @transformer \App\Transformer\UserTransformer
     * }
     * 
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => auth()->factory()->getTTL() * 684654324
        ]);
    }
}
