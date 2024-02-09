<?php

namespace App\Http\Controllers\Authentication;
use App\Http\Requests\AuthorizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Log;
use DB;

class UserController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function register(AuthorizationRequest $request) : JsonResponse {
        $request->validate($request->register());
        try {
            DB::beginTransaction();
            $this->user->registerUser(name: $request->name, email: $request->email, password: $request->password);
            $token = $this->user->createToken(config('passport.personal_access_client.secrect'))->accessToken;
            DB::commit();
            return response()->json(['access_token' => $token]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            return $e;
        }
        
    }

    public function login(AuthorizationRequest $request) : JsonResponse {
        $request->validate($request->login());
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Generate an access token for the user
            $accessToken = $user->createToken(config('passport.personal_access_client.secrect'))->accessToken;

            // Return the access token as a response
            return response()->json(['access_token' => $accessToken]);
        } else {
            // If authentication fails, return an error response
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function test(Request $request) {
        return response()->json(['access_token' => $request->bearerToken()]);
    }
}
