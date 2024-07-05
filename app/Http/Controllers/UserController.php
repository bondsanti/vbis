<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\ReportLogin;
use App\Models\RolePrinter;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use App\Models\Logs;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function addApiDatabyUsers($data)
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

    private function addApiDataToUsers($users)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        foreach ($users as $user) {
            try {
                $response = $client->request('GET', $apiUrl.'/users', [
                    'query' => ['user_id' => $user->user_id],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiToken
                    ]
                ]);

                $user->apiData = json_decode($response->getBody(), true);

                $imgCheck = optional(optional($user->apiData)['data'])['img_check'];
                //$remoteFile = $imgCheck ? "http://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
                $remoteFile = $imgCheck ? "http://localhost/hr/imageUser/employee/{$imgCheck}" : null;
                $fileExists = false;

                if ($remoteFile) {
                    $ch = curl_init($remoteFile);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_exec($ch);
                    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    $fileExists = ($responseCode == 200);
                }

                $user->remoteFile = $remoteFile;
                $user->fileExists = $fileExists;

            } catch (\Exception $e) {

                //Log::error('API request failed for user ' . $user->id . ': ' . $e->getMessage());
                $user->apiData = null;
            }
        }
    }

    private function addApiDataToDepartment()
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        try {
            $response = $client->request('GET', $apiUrl.'/departments', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);

            $departmentData = json_decode($response->getBody(), true);
            if (isset($departmentData['data']) && is_array($departmentData['data'])) {
                return $departmentData['data'];
            } else {
                return null;
            }
        } catch (\Exception $e) {
            $departmentData = null;
        }

        return $departmentData;
    }

    public function getUserSignInByYear(Request $request, $year)
    {
        if ($year != "All") {

            $dataSign = ReportLogin::whereRaw("YEAR(dates) = ?", [$year])
                ->where('page', '<>', 'LoginPage')
                ->distinct(['username', 'page', 'dates'])
                ->get();
        } else {
            // ดึงข้อมูลย้อนหลัง 3 ปี
            $dataSign = ReportLogin::whereRaw("YEAR(dates) >= YEAR(CURDATE()) - 3")
                ->where('page', '<>', 'LoginPage')
                ->distinct(['username', 'page', 'dates'])
                ->get();
        }

        $dataUser = User::select('code', 'name_th')->get();

        // ใช้ map เพื่อรวมข้อมูล user_info จาก dataUser ไปยัง dataSign
        // $dataSign = $dataSign->map(function ($item) use ($dataUser) {
        //     $user = $dataUser->where('code', $item->username)->first();
        //     // เพิ่มข้อมูล user_info ลงในรายการ
        //     $item->user_info = $user ? $user->name_th : null;
        //     return $item;
        // });

        return response()->json(['data' => $dataSign]);
    }

    public function getUsers(Request $request)
    {

        $loggedInUser = User::where('user_id',$request->session()->get('loginId'))->first();


        $userCounts = User::selectRaw('SUM(active = 1) as active_count, SUM(active = 0) as inactive_count')
            ->first();

        $query = User::with(['role_report_ref:code_user,level', 'role_printer_ref:user_id,role_type,active']);

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        //$users = $query->orderBy('code', 'desc')->paginate(10);

        $users = $query->orderBy('code', 'desc')->paginate(10);

        // API
        $this->addApiDataToUsers($users);

        $departmentData = $this->addApiDataToDepartment();


        if ($loggedInUser->active_vbis == 1) {
            return view('users.index', [
                'users' => $users,
                'departments' => $departmentData,
                'CountUserActive' => $userCounts->active_count,
                'CountUserUnActive' => $userCounts->inactive_count,
            ]);
        } else {
            return back();
        }
    }

    public function updateActive(Request $request)
    {
        $users = User::where('user_id',$request->user_id)->first();


        if ($users) {

            if ($request->active_type == "report") {
                $users->active_report = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "printer") {
                $users->active_printer = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "user") {
                $users->active = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "vbis") {
                $users->active_vbis = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "broker") {
                $users->active_broker = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "rental") {
                $users->active_rental = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "vproject") {
                $users->active_vproject = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "vblead") {
                $users->active_vblead = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "agent") {
                $users->active_agent = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "vbasset") {
                $users->active_vbasset = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "stock_h") {
                $users->high_rise = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "stock_l") {
                $users->low_rise = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            }
        }

        return response()->json(['message' => 'error'], 404);
    }

    public function updateRole(Request $request)
    {

        $users = RolePrinter::where('user_id', $request->user_id)->first();


        if ($users) {

            if ($request->role_system == "printer") {
                $users->role_type = $request->role_type;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            }
        }

        return response()->json(['message' => 'error'], 404);
    }

    public function sendEmail(Request $request)
    {
        $userId = $request->input('user_id');

        $user = User::with(['role_report_ref:code_user,level', 'role_printer_ref:user_id,role_type,active'])
        ->where('user_id', $userId)->where('active', 1)->get();

        if ($user) {

            $email = $user->email;

            Mail::send(
                'auth.forget.mail',
                ['accessRole' => url("forget/reset/{$token}"), 'dataUser' => $user],
                function (Message $message) use ($email) {
                    $message->to($email)
                        ->subject('แจ้งสิทธิเข้าใช้งานระบบ VBNext');
                }
            );


            return response()->json(['success' => true]);
        }




    }


    public function checkIn(Request $request)
    {
        if ($request->session()->has('loginId')) {

            $data = User::where('user_id', $request->session()->get('loginId'))->first();
            $this->addApiDatabyUsers($data);

            $currentDate = date('Y-m-d');

            // ตรวจสอบว่าผู้ใช้งานได้ลงเวลาเข้าหรือยัง
            $checkIn = Checkin::where('username', $data->code)
                ->where('page', 'Loginpage')
                ->where('action', '1')
                ->whereDate('dates', $currentDate)
                ->exists();

            // ตรวจสอบว่าผู้ใช้งานได้ลงเวลาออกหรือยัง
            $checkOut = Checkin::where('username', $data->code)
                ->where('page', 'Loginpage')
                ->where('action', '0')
                ->whereDate('dates', $currentDate)
                ->exists();

            $dataCheckIn = Checkin::where('username', $data->code)->where('page', 'Loginpage')
            ->whereDate('dates', $currentDate)->get();

            $agent = new Agent();
            $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

            if ($deviceType=="Mobile") {
              return view('checkin.index', compact('data','checkIn','checkOut','dataCheckIn'));
            }else{
                return view('auth.main', compact('data'));
            }


        }
    }

    public function saveCheckIn(Request $request)
    {

        try {
            $user = User::where('user_id', $request->session()->get('loginId'))->first();

            DB::connection('mysql_report')->table('log_login')->insert([
                'username' => $user->code,
                'dates' => date('Y-m-d'),
                'timeStm' => $request->datetime,
                'latitude' => $request->lat,
                'longitude' => $request->long,
                'page' => 'LoginPage',
                'action' => 1
            ]);

            Logs::addLog($user->user_id, 'checkin', $user->code . ' Checkin Success', 'deviceType'); // You need to pass a proper value for $deviceType

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }


    }



    public function saveCheckOut(Request $request)
    {

        try {
            $user = User::where('user_id', $request->session()->get('loginId'))->first();

            DB::connection('mysql_report')->table('log_login')->insert([
                'username' => $user->code,
                'dates' => date('Y-m-d'),
                'timeStm' => $request->datetime,
                'latitude' => $request->lat,
                'longitude' => $request->long,
                'page' => 'LoginPage',
                'action' => 0
            ]);

            Logs::addLog($user->user_id, 'checkout', $user->code . ' Checkout Success', 'deviceType'); // You need to pass a proper value for $deviceType

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }


    }





}
