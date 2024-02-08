<?php

namespace App\Http\Controllers;

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

class CustomAuthController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => '94150993-bd31-4c99-a0cd-6cd4580e912f',
            'clientSecret'            => 'okV8Q~lX.2DXtcQ1qlc9lENBWu.I3S3o_S8J2bXR',
            'redirectUri'             => 'https://vbis.vbeyond.co.th/mscallback',
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

        $user_hr = User::where('email', $userData['mail'])->where('active', 1)->first();

        //dd($user_hr);
        if (!$user_hr) {

            Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {


            $request->session()->put('loginId', $user_hr->id);

            $token = bin2hex(random_bytes(16)); //Create token
            $user_hr->token = $token;
            $user_hr->save();

            DB::connection('mysql_report')->table('log_login')->insert([
                'username' => $user_hr->code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'LoginConnect'
            ]);

            Alert::success('เข้าสู่ระบบสำเร็จ', 'ยินดีต้อนรับเข้าสู่ระบบ');
            return redirect('/main');
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

                DB::table('mysql_report.log_login')->insert([
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
        $data = array();
        $dataProject = array();
        $dataVconex = array();

        if ($request->session()->has('loginId')) {

            $data = User::where('id', $request->session()->get('loginId'))->first();
            $dataProject = DB::connection('mysql_project')->table('role_user')->where('user_id', $request->session()->get('loginId'))->first();
            $dataVconex = DB::connection('mysql_vconex')->table('users')->where('code', $data->code)->get()->count();
        }

        return view('auth.main', compact('data', 'dataProject', 'dataVconex'));
    }

    public function logoutUser(Request $request)
    {
        if ($request->session()->has('loginId')) {
            Alert::success('ออกจากระบบเรียบร้อย', 'ไม่พบกันใหม่ :)');
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
}
