<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Specialtactics\L5Api\Http\Controllers\Features\JWTAuthenticationTrait;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Response;

class AuthController extends Controller
{
    public function token(Request $request) 
    {

        try {
            $authHeader = $request->header('Authorization');

            if (strtolower(substr($authHeader, 0, 5)) !== 'basic') {
                return Response::json(['message' => 'Authorization should be type basic'], 400);
            }

            $credentials = base64_decode(trim(substr($authHeader, 5)));

            [$login, $password] = explode(':', $credentials, 2);

            if (! $token = auth()->attempt(['email' => $login, 'password' => $password])) {
                return Response::json(['message' => 'User not registered'], 400);
            }

            //Storing user id and token in the cache
            $user_id = User::where("email", "=", $login)->get(['user_id']);
            return $this->respondWithToken($user_id[0], $token);
 
        }catch(Exception $e) {
            return Response::json(['message' => 'Internal Server Error'], 500);
        }

        
        //return User::create($request->all());

    }
        /**
     * Log the user out (Invalidate the token).
     *
     * @return Response
     */
    public function logout()
    {
        auth()->logout();

        return $this->response->noContent();
    }

    /**
     * Refreshes a jwt (ie. extends it's TTL)
     *
     * @return Response
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function getUser()
    {
        return $this->api->raw()->get('users/' . $this->auth->user()->getKey());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return Response
     */
    protected function respondWithToken($user_id, $token)
    {
        $tokenResponse = new \Stdclass;

        $tokenResponse->jwt = $token;
        $tokenResponse->token_type = 'bearer';
        $tokenResponse->expires_in = auth()->factory()->getTTL();
        $tokenResponse->id = $user_id;
        //Cache::put($token, $user_id);
        return $this->response->item($tokenResponse, $this->getTransformer())->setStatusCode(200);
    }
}
