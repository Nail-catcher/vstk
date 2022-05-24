<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    use ThrottlesLogins;

    public function refresh(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $request->refresh_token,
                    'client_id' => config('passport.personal_access_client.id'),
                    'client_secret' => config('passport.personal_access_client.secret'),
                    'scope' => '',
                ],
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            return response()->json([
                'message' => 'The refresh token is invalid.'
            ], 401);
        }


        return json_decode((string)$response->getBody(), true);
    }
}
