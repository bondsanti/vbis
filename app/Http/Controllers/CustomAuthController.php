<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use GuzzleHttp\Client;

class CustomAuthController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => '94150993-bd31-4c99-a0cd-6cd4580e912f',
            'clientSecret'            => 'okV8Q~lX.2DXtcQ1qlc9lENBWu.I3S3o_S8J2bXR',
            'redirectUri'             => 'http://localhost:8000/mscallback',
            'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'                  => 'user.read'
        ]);
    }


    public function index()
    {
        return view('auth.index');
    }

    public function signin()
    {

        $authorizationUrl = $this->provider->getAuthorizationUrl();

        // Get the state generated for you and store it to the session.
        session(['oauth2state' => $this->provider->getState()]);

        // Redirect the user to the authorization URL.
        return redirect()->away($authorizationUrl);
    }

    public function callback(Request $request)
    {
        // Try to get an access token using the authorization code grant.
        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $request->get('code')
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        $graph = new Client();
        $response = $graph->request('GET', 'https://graph.microsoft.com/v1.0/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken->getToken()
            ]
        ]);

        // Parse the response body and output the user data
        $userData = json_decode($response->getBody(), true);

        return response()->json($userData);


    }
}

