<?php

namespace App\Http\Controllers\Authentication;
use App\Http\Requests\AuthorizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Log;
use DB;

class UserController extends Controller
{
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function register(AuthorizationRequest $request) : mixed {
        $request->validate($request->register());
        try {
            DB::beginTransaction();
            $res = $this->user->registerUser(name: $request->name, email: $request->email, password: $request->password);
            DB::commit();
            $token = $this->user->createToken(config('passport.personal_access_client.secret'))->accessToken;
            return successResponse($token, new UserResource($res), __('auth.register'), 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::emergency($e);
            return errorResponse($e, __('common.error'), 500);
        }
        
    }

    public function login(AuthorizationRequest $request) : JsonResponse {
        $request->validate($request->login());
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // Generate an access token for the user
            $accessToken = $user->createToken(config('passport.personal_access_client.secrct'))->accessToken;
            // Return the access token as a response
            return successResponse($accessToken, $user, __('auth.login'), 200);
        } else {
            // If authentication fails, return an error response
            return errorResponse(NULL, __('auth.invalid_user'), 401);
        }
    }

    public function test(Request $request) {
        return response()->json(['access_token' => $request->bearerToken()]);
    }
}
