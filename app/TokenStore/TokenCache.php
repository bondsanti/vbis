<?php
namespace App\TokenStore;
class TokenCache {
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

    public function storeTokens($accessToken, $user) {
        session([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires(),
            'userName' => $user->getDisplayName(),
            'userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName()
        ]);
    }
    public function clearTokens() {
        session()->forget('accessToken');
        session()->forget('refreshToken');
        session()->forget('tokenExpires');
        session()->forget('userName');
        session()->forget('userEmail');
    }
    public function getAccessToken() {
        // Check if tokens exist
        if (empty(session('accessToken')) || empty(session('refreshToken')) || empty(session('tokenExpires'))) {
            return '';
        }
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if (session('tokenExpires') <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh
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
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => session('refreshToken')
                ]);
                // Store the new values
                $this->updateTokens($newToken);
                return $newToken->getToken();
            }
            catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }
        // Token is still valid, just return it
        return session('accessToken');
    }
    public function updateTokens($accessToken) {
        session([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires()
        ]);
    }
}
