<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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

    public function loginVbis(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'password' => 'required'
        ], [
            'code.required' => 'ป้อนรหัสพนักงาน',
            'password.required' => 'ป้อนรหัสผ่าน'
        ]);

        $user_hr = User::where('code', $request->code)->orWhere('old_code', $request->code)->where('active', 1)->first();

        if (!$user_hr) {

            Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            if (Hash::check($request->password, $user_hr->password)) {

                if ($user_hr->is_auth == 0) {

                    $request->session()->put('dataIsAuth', $user_hr);
                    Alert::info('กรุณาเปลี่ยนรหัสผ่าน');
                    return redirect('/change-password');
                }

                $request->session()->put('loginId', $user_hr->id);

                $token = bin2hex(random_bytes(16)); //Create token
                $user_hr->token = $token;
                $user_hr->save();

                DB::table('vbeyond_report.log_login')->insert([
                    'username' => $user_hr->code,
                    'dates' => date('Y-m-d'),
                    'timeStm' => date('Y-m-d H:i:s'),
                    'page' => 'LoginConnect'
                ]);

                Alert::success('เข้าสู่ระบบสำเร็จ', 'ยินดีต้อนรับเข้าสู่ระบบ');
                return redirect('/main');
            } else {

                Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            }
        }
    }

    public function profileUser(Request $request)
    {
        $data= array();
        if ($request0>session()->has('loginId')) {

            $data = User::where('id',$request->session()->get('loginId'))->first();
        }
        return view('auth.main', compact('data'));
    }

    public function logoutUser()
    {
        if ($request->session()->has('loginId')) {
            Alert::success('ออกจากระบบเรียบร้อย','ไม่พบกันใหม่ :)');
            $request->session()->pull('loginId');
            return redirect('/');
        }
    }
}
