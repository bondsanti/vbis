<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class CustomAuthController extends Controller
{
    protected $provider;

    public function __construct()
    {

        $this->provider = new GenericProvider([
            'clientId'                => env('OAUTH_CLIENT_ID'),
            'clientSecret'            => env('OAUTH_CLIENT_SECRET'),
            'redirectUri'             => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize'            => env('OAUTH_URL_AUTHORIZE'),
            'urlAccessToken'          => env('OAUTH_URL_ACCESS_TOKEN'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => env('OAUTH_SCOPES')
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
        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        if (!$request->has('code') || !$request->has('state')) {
            Alert::error('การร้องขอไม่ถูกต้อง', 'กรุณาลองอีกครั้ง');
            return redirect('/');
        }

        if ($request->get('state') !== session('oauth2state')) {
            session()->forget('oauth2state');
            Alert::error('สถานะไม่ถูกต้อง', 'กรุณาลองอีกครั้ง');
            return redirect('/');
        }

        try {
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

            $graph = new Client();
            $response = $graph->request('GET', 'https://graph.microsoft.com/v1.0/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken->getToken()
                ]
            ]);

            $userData = json_decode($response->getBody(), true);
            $userEmail = $userData['mail'] ?? null;

            if (!$userEmail) {
                Alert::error('ไม่พบอีเมล์ผู้ใช้', 'กรุณาลองอีกครั้ง');
                return redirect('/');
            }

            $user = User::where('email', $userEmail)->where('active', 1)->first();
           // dd($user);

            if (!$user) {
                Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            } else {
                $request->session()->put('loginId', $user->user_id);

                $token = bin2hex(random_bytes(16)); //Create token
                $user->token = $token;
                $user->save();

                DB::connection('mysql_report')->table('log_login')->insert([
                    'username' => $user->code,
                    'dates' => date('Y-m-d'),
                    'timeStm' => date('Y-m-d H:i:s'),
                    'page' => 'vbnext'
                ]);

                Logs::addLog($user->user_id, 'Login' ,$user->email. ' Login Microsoft Success',$deviceType);

                Alert::success('เข้าสู่ระบบสำเร็จ', 'ยินดีต้อนรับเข้าสู่ระบบ');
                return redirect('/main');
            }

        } catch (\Exception $e) {

            Logs::addLog($user->user_id,'API','API request failed for user' . $e->getMessage(), $deviceType);
            Alert::error('เกิดข้อผิดพลาดในการเข้าสู่ระบบ', $e->getMessage());
            return redirect('/');

        }
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

        $user = User::where('code', $request->code)->orWhere('old_code', $request->code)->where('active', 1)->first();
        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
        //dd($user);
        if (!$user) {

            Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            if (Hash::check($request->password, $user->password)) {

                if ($user->is_auth == 0) {

                    $request->session()->put('dataIsAuth', $user);
                    Alert::info('กรุณาเปลี่ยนรหัสผ่าน');
                    return redirect('/change-password');

                }


                $request->session()->put('loginId', $user->user_id);

                $token = bin2hex(random_bytes(16)); //Create token
                $user->token = $token;
                $user->save();


                Logs::addLog($request->session()->get('loginId'), 'Login', 'Login CodeEmployee', $deviceType);



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
        $agent = new Agent();

        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        if ($request->session()->has('loginId')) {
            $data = User::where('user_id', $request->session()->get('loginId'))->first();
            $this->addApiDataToUsers($data);
        }

        if ($deviceType=="Mobile") {
            return view('auth.moblie', compact('data'));
        } elseif($deviceType == "Desktop" || $deviceType == "Tablet") {
            return view('auth.main', compact('data'));
        }

    }

    public function logoutUser(Request $request)
    {
        if ($request->session()->has('loginId')) {

            $agent = new Agent();
            $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
            Logs::addLog($request->session()->get('loginId'), 'Logout' ,'Logout Microsoft Success',$deviceType);

            Alert::success('ออกจากระบบเรียบร้อย', 'ไว้พบกันใหม่ :)');
            $request->session()->pull('loginId');
            return redirect('/');
        }
    }

    public function showForgetForm()
    {
        return view("auth.forget.index");
    }

    //ส่ง link Email เพื่อ Reset
    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'ป้อน Email',
                'email.email' => 'รูปแบบ Email ไม่ถูกต้อง',
            ]
        );

        $email = $request->email;
        $token = bin2hex(random_bytes(16));

        $user = User::where('email', $email)->whereNull('resign_date')->where('active', 1)->orderBy('id', 'DESC')->first();

        if ($user) {

            $user->token_forget = $token;
            $user->save();


            Mail::send(
                'auth.forget.mail',
                ['resetLink' => url("forget/reset/{$token}"), 'users' => $user],
                function (Message $message) use ($email) {
                    $message->to($email)
                        ->subject('ตั้งค่ารหัสผ่านใหม่');
                }
            );


            Alert::success('สำเร็จ', 'ขอ Reset Password สำเร็จ')->persistent(true)->autoclose(3000);
            return redirect('/forget/success');
        } else {
            Alert::warning('ไม่พบ Email ', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        }
    }

    public function update(Request $request)
    {

        $user = User::where('id', "=", $request->user_id)->first();

        $request->validate([
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/', //one lowercase letter
                'regex:/[A-Z]/', //one uppercase letter
                'regex:/[0-9]/', //one least one digit
                'regex:/[@$!%*#?&]/', //one least one character
            ],

            'confrimpassword' => ['required', 'same:password']

        ], [
            'password.required' => 'ป้อนรหัสผ่านใหม่',
            'confrimpassword.same' => 'รหัสผ่านไม่ตรงกัน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'password.regex' => 'รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก 1 ตัว,ตัวพิมพ์ใหญ่ 1 ตัว,ตัวเลข 1 ตัว และอักษรพิเศษ 1 ตัว',
            'confrimpassword.required' => 'ป้อนยืนยันรหัสผ่านใหม่',

        ]);

        if (Hash::check($request->password, $user->old_password)) {
            Alert::warning('รหัสผ่านซ้ำกับรหัสเดิม', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            $user->password = Hash::make($request->password);
            $user->is_auth = "1";
            $user->token_forget = "";
            $user->save();
            Alert::success('เปลี่ยนรหัสผ่านสำเร็จ')->persistent(true)->autoclose(3000);
            return redirect('/forget/complate');
        }
    }

    public function edit(Request $request, $token)
    {

        $user = User::where('token_forget', "=", $token)->first();
        //dd($user);
        if ($user) {
            return view("auth.forget.reset", compact('user'));
        } else {
            //abort(404);

            return view("auth.forget.token_exp");
        }
    }

    public function complate()
    {
        return view("auth.forget.complete");
    }

    public function sendEmailSuccess()
    {
        return view("auth.forget.success");
    }

    public function changePassword()
    {

        return view('auth.forget.password');
    }

    public function updatePassword(Request $request)
    {

        $user = User::where('id', Session::get('dataIsAuth')->id)->first();

        $request->validate([
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/', //one lowercase letter
                'regex:/[A-Z]/', //one uppercase letter
                'regex:/[0-9]/', //one least one digit
                'regex:/[@$!%*#?&]/', //one least one character
            ],

            'confrimpassword' => ['required', 'same:password']

        ], [
            'password.required' => 'ป้อนรหัสผ่านใหม่',
            'confrimpassword.same' => 'รหัสผ่านไม่ตรงกัน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'password.regex' => 'รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก 1 ตัว,ตัวพิมพ์ใหญ่ 1 ตัว,ตัวเลข 1 ตัว และอักษรพิเศษ 1 ตัว',
            'confrimpassword.required' => 'ป้อนยืนยันรหัสผ่านใหม่',

        ]);

        if (Hash::check($request->password, $user->password)) {
            Alert::warning('รหัสผ่านซ้ำกับรหัสเดิม', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            $user->old_password = $user->password;
            $user->password = Hash::make($request->password);
            $user->is_auth = "1";
            $user->save();

            $user->refresh();

            $request->session()->put('loginId', $user->id);

            DB::connection('mysql_report')->table('log_login')->insert([
                'username' => $user->code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'LoginConnect'
            ]);

            Alert::success('เข้าสู่ระบบสำเร็จ', 'ยินดีต้อนรับเข้าสู่ระบบ');
            return redirect('/main');
        }
    }

    private function addApiDataToUsers($data)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

            try {
                $response = $client->request('GET', $apiUrl.'/users', [
                    'query' => ['user_id' => $data->user_id],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiToken
                    ]
                ]);

                $data->apiData = json_decode($response->getBody(), true);
                $imgCheck = optional(optional($data->apiData)['data'])['img_check'];
                $remoteFile = $imgCheck ? "https://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
                //$remoteFile = $imgCheck ? "http://localhost/hr/imageUser/employee/{$imgCheck}" : null;
                $fileExists = false;

                if ($remoteFile) {
                    $ch = curl_init($remoteFile);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_exec($ch);
                    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    $fileExists = ($responseCode == 200);
                }

                $data->remoteFile = $remoteFile;
                $data->fileExists = $fileExists;



                Logs::addLog($data->user_id, 'API' ,'API request Success for user', $deviceType);

            } catch (\Exception $e) {

                Logs::addLog($data->user_id,'API','API request failed for user' . $e->getMessage(), $deviceType);
                $data->apiData = null;
            }

    }
}
