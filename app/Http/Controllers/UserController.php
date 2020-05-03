<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Cache; Goos idea to use Cache, but This is a test of 5 days

use App\Models\User;
use Response;

class UserController extends Controller
{
    public static $model = User::class;

    public function createUser(Request $request) 
    {
        $user = $request->only(['email', 'password']);
        try{
            
            $new_user = User::create(array_merge($request->all(), ['primary_role' => 1])); //Always admin for now
            $new_user_id = $new_user->getJWTIdentifier();
            $token = auth()->attempt(['email' => $user["email"], 'password' => $user["password"]]);
            return $this->respondWithToken($new_user_id, $token);
        }catch(Exception $e){
            return Response::json(['message' => 'User already Exists'], 400);
        }
    }

    protected function respondWithToken($user_id, $token)
    {
        $tokenResponse = new \Stdclass;

        $tokenResponse->jwt = $token;
        $tokenResponse->token_type = 'bearer';
        $tokenResponse->expires_in = auth()->factory()->getTTL();
        //Cache::put($token, $user_id);
        $tokenResponse->id = $user_id;
        return $this->response->item($tokenResponse, $this->getTransformer())->setStatusCode(200);
    }
}
