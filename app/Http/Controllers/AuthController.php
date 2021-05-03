<?php namespace App\Http\Controllers;

use App\Jobs\DeletingFiles;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($graphRequest)
    {
        DeletingFiles::dispatch();
//        $credentials = request(['email', 'password']);
//        if (! $token = auth()->attempt($credentials)) {
        if (! $token = auth()->attempt($graphRequest)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
//        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function registration($graphRequest)
    {
        $user = new User();
        $user->name = $graphRequest['name'];;
        $user->email = $graphRequest['email'];;
        $user->password = Hash::make($graphRequest['password']);
        $user->save();
        return response()->json(['message' => 'Successfully registration!']);
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
