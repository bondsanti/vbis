<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

use App\TokenStore\TokenCache;

use Microsoft\Graph\Core\GraphConstants;

class AuthController extends Controller
{

    public $oauth_env = array(
        'OAUTH_APP_ID' => '94150993-bd31-4c99-a0cd-6cd4580e912f',
        'OAUTH_APP_PASSWORD'=>'okV8Q~lX.2DXtcQ1qlc9lENBWu.I3S3o_S8J2bXR',
        'OAUTH_REDIRECT_URI'=>'http://localhost:8000/mscallback',
        'OAUTH_SCOPES'=>'openid profile user.read email',
        //'OAUTH_AUTHORITY' => 'https://login.microsoftonline.com/5f1b572d-118b-45fc-b023-0f6d96cc9f24',

        'OAUTH_AUTHORITY'=>'https://login.microsoftonline.com/common',
        'OAUTH_AUTHORIZE_ENDPOINT'=>'/oauth2/v2.0/authorize',
        'OAUTH_TOKEN_ENDPOINT'=>'/oauth2/v2.0/token',

    );

    public function signin(){
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $this->oauth_env['OAUTH_APP_ID'],
            'clientSecret'            => $this->oauth_env['OAUTH_APP_PASSWORD'],
            'redirectUri'             => $this->oauth_env['OAUTH_REDIRECT_URI'],
            'urlAuthorize'            => $this->oauth_env['OAUTH_AUTHORITY'].$this->oauth_env['OAUTH_AUTHORIZE_ENDPOINT'],
            'urlAccessToken'          => $this->oauth_env['OAUTH_AUTHORITY'].$this->oauth_env['OAUTH_TOKEN_ENDPOINT'],
            'urlResourceOwnerDetails' => '',
            'scopes'                  => $this->oauth_env['OAUTH_SCOPES']
        ]);
        $authUrl = $oauthClient->getAuthorizationUrl();

        // Save client state so we can validate in callback
        session(['oauthState' => $oauthClient->getState()]);

        // Redirect to AAD signin page
        return redirect()->away($authUrl);
    }

    public function callback(Request $request){
        // Validate state
        $expectedState = session('oauthState');
        $request->session()->forget('oauthState');
        $providedState = $request->query('state');

        if (!isset($expectedState) || !isset($providedState) || $expectedState != $providedState) {
            return redirect('/')
                ->with('error', 'Invalid auth state')
                ->with('errorDetail', 'The provided auth state did not match the expected value');
        }

        // Authorization code should be in the "code" query param
        $authCode = $request->query('code');
        if (isset($authCode)) {
            // Initialize the OAuth client
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => $this->oauth_env['OAUTH_APP_ID'],
                'clientSecret'            => $this->oauth_env['OAUTH_APP_PASSWORD'],
                'redirectUri'             => $this->oauth_env['OAUTH_REDIRECT_URI'],
                'urlAuthorize'            => $this->oauth_env['OAUTH_AUTHORITY'].$this->oauth_env['OAUTH_AUTHORIZE_ENDPOINT'],
                'urlAccessToken'          => $this->oauth_env['OAUTH_AUTHORITY'].$this->oauth_env['OAUTH_TOKEN_ENDPOINT'],
                'urlResourceOwnerDetails' => '',
                'scopes'                  => $this->oauth_env['OAUTH_SCOPES']
            ]);

            try {
                // Make the token request
                $accessToken = $oauthClient->getAccessToken('authorization_code', ['code' => $authCode]);

                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());

                $user = $graph->createRequest('GET', '/me?select=displayName,mail,userPrincipalName')
                    ->setReturnType(Model\User::class)
                    ->execute();


                $tokenCache = new TokenCache();
                $tokenCache->storeTokens($accessToken, $user);


                return redirect('/');
            }
            catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return redirect('/')
                    ->with('error', 'Error requesting access token')
                    ->with('errorDetail', $e->getMessage());
            }
        }
        return redirect('/')
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    public function signout(){
        $tokenCache = new TokenCache();
        $tokenCache->clearTokens();
        return redirect('/');
    }

    public function createClient($baseUrl,$apiVersion,$proxyPort = null){
        $tokenCache = new TokenCache();
        $token = $tokenCache->getAccessToken();
        if(empty($token)){
            return false;
        }
        $headers = [
            'Host' => $baseUrl.$apiVersion,
            'Content-Type' => 'application/json',
            'SdkVersion' => 'Graph-php-' . GraphConstants::SDK_VERSION,
            'Authorization' => 'Bearer ' . $token
        ];
        $clientSettings = [
            'base_uri' => $baseUrl,
            'headers' => $headers,
            'http_errors' => false
        ];
        if ($proxyPort !== null) {
            $clientSettings['verify'] = false;
            $clientSettings['proxy'] = $proxyPort;
        }
        $client = new \GuzzleHttp\Client($clientSettings);
        return $client;
    }
}
