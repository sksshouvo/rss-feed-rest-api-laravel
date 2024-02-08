<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\AuthorizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Log;
use DB;

class UserController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function register(AuthorizationRequest $request) : mixed {
        $request->validate($request->register());
        try {
            DB::beginTransaction();
            $this->user->registerUser(name: $request->name, email: $request->email, password: $request->password);
            $token = $this->user->createToken(config('passport.personal_access_client.secrect'))->accessToken;
            DB::commit();
            return $token;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            return $e;
        }
        
    }

    public function login(AuthorizationRequest $request) : string {
        $request->validate($request->login());
        return "login";
    }

    public function test(Request $request) {
        return "HI";
    }
}
