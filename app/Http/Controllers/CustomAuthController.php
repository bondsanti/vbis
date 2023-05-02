<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; //Query Builder
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Session;

class CustomAuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }
    public function reset_pass(){

        $data = array();

        if (Session::has('loginId')) {
           $data = User::where('id',"=", Session::get('loginId'))->first();
        }
        return view("auth.reset.index",compact('data'));
    }
    public function reset_create(Request $request){

        $user = User::where('id',"=", Session::get('loginId'))->first();

        $request->validate([
            'password'=> ['required',
            'min:8',
            'regex:/[a-z]/', //one lowercase letter
            'regex:/[A-Z]/', //one uppercase letter
            'regex:/[0-9]/', //one least one digit
            'regex:/[@$!%*#?&]/', //one least one character
        ],

            'confrimpassword'=>['required','same:password']

        ] ,[
            'password.required' => 'ป้อนรหัสผ่านใหม่',
            'confrimpassword.same'=>'รหัสผ่านไม่ตรงกัน',
            'password.min'=>'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'password.regex'=>'รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก 1 ตัว,ตัวพิมพ์ใหญ่ 1 ตัว,ตัวเลข 1 ตัว และอักษรพิเศษ 1 ตัว',
            'confrimpassword.required'=>'ป้อนยืนยันรหัสผ่านใหม่',

        ]);

        if (Hash::check($request->password, $user->password)) {
            Alert::warning('รหัสผ่านซ้ำกับรหัสเดิม', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        }else{
            $user->old_password = $user->password;
            $user->password = Hash::make($request->password);
            $user->is_auth = "1";
            $user->save();
            Alert::success('เปลี่ยนรหัสผ่านสำเร็จ');
            return redirect('/');
        }


    }

    public function loginUser(Request $request){
        $request->validate([
            'code' => 'required',
            'password' => 'required'
        ]
        ,[
            'code.required' => 'ป้อนรหัสพนักงาน',
            'password.required'=>'ป้อนรหัสผ่าน'
        ]);

        $user = User::where('code', '=', $request->code)->orWhere('old_code', '=', $request->code)->first();
        //dd($user);
        //$user = User::where('code', '=', $request->code)->first();
        if($user){
            if($user->active !=0 or $user->resign_date==null){
                    if(Hash::check($request->password, $user->password)){

                            $request->session()->put('loginId',$user->id);
                            $token = bin2hex(random_bytes(16));
                            if ($user->is_auth==0) {
                                return redirect('/resetpassword');
                            }else{
                                $user->token = $token;
                                $user->save();

                                DB::table('vbeyond_report.log_login')->insert([
                                    'username' => $user->code,
                                    'dates' => date('Y-m-d'),
                                    'timeStm' => date('Y-m-d H:i:s'),
                                    'page' => 'LoginConnect'
                                ]);

                                Alert::success('เข้าสู่ระบบสำเร็จ');
                                return redirect('/');
                            }



                    }else{
                        Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                        //return back()->with('ล้มเหลว','รหัสผ่านไม่ถูกต้อง');
                        return back();
                    }


            }else{
                Alert::warning('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                //return back()->with('ล้มเหลว','ไม่พบผู้ใช้งาน');
                return back();
            }

        }else{
            Alert::warning('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            //return back()->with('ล้มเหลว','ไม่พบผู้ใช้งาน');
            return back();
        }
    }
    public function profile(Request $request){
        $data = array();
        if($request->session()->has('loginId')){

            $data = User::where('id','=',$request->session()->get('loginId'))->first();
            //dd($data->code);
        }
        $dataProject = DB::connection('mysql_project')->table('role_user')->where('user_id', $request->session()->get('loginId'))->first();
        $dataVconex = DB::connection('mysql_vconex')->table('users')->where('code', $data->code)->get()->count();
        //dd($dataVconex);
        return view('auth.main',compact('data', 'dataProject', 'dataVconex'));
    }
    public function logoutUser(Request $request){

        if($request->session()->has('loginId')){
            Alert::success('ออกจากระบบเรียบร้อย');
            $request->session()->pull('loginId');
            return redirect('login');
        }

    }

}
