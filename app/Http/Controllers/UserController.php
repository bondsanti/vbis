<?php

namespace App\Http\Controllers;

use App\Mail\AccessRoleSendMail;
use App\Models\Checkin;
use App\Models\ReportLogin;
use App\Models\RolePrinter;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use App\Models\Logs;
use App\Models\RoleBoker;
use App\Models\RoleRental;
use App\Models\RoleReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    private function addApiDatabyUsers($data)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');
        $appHR = env('APP_HR');
        $agent = new Agent();
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        try {
            $response = $client->request('GET', $apiUrl . '/users', [
                'query' => ['user_id' => $data->user_id],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);

            $data->apiData = json_decode($response->getBody(), true);
            $imgCheck = optional(optional($data->apiData)['data'])['img_check'];
            //$remoteFile = $imgCheck ? "https://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
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



            Logs::addLog($data->user_id, 'API', 'API request Success for user', $deviceType);
        } catch (\Exception $e) {

            Logs::addLog($data->user_id, 'API', 'API request failed for user' . $e->getMessage(), $deviceType);
            $data->apiData = null;
        }
    }

    private function addApiDataToUsers($users)
    {
        $client = new Client();
        $apiUrl = env('API_URL');
        $apiToken = env('API_TOKEN');

        $stockApiUrl = env('APP_STOCK');
        $stockApiToken = env('API_TOKEN_AUTH');

        $projectApiUrl = env('APP_PROJECT');
        $projectApiToken = env('API_TOKEN_AUTH');
        $appHR = env('APP_HR');
        $filteredUsers = collect();
        foreach ($users as $user) {
            // ดึงข้อมูลจาก API แรก
            try {
                $response = $client->request('GET', $apiUrl . '/users', [
                    'query' => ['user_id' => $user->user_id],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiToken
                    ]
                ]);
                $user->apiData = json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                $user->apiData = null;
            }

            // ดึงข้อมูลจาก API Stock
            try {
                $response2 = $client->request('GET', $stockApiUrl . '/api/users-list/' . $user->user_id, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $stockApiToken
                    ]
                ]);
                $user->apiDataStock = json_decode($response2->getBody(), true);
            } catch (\Exception $e) {
                $user->apiDataStock = null;
            }

            // ดึงข้อมูลจาก API Project
            try {
                $response3 = $client->request('GET', $projectApiUrl . '/api/users-list/' . $user->user_id, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $projectApiToken
                    ]
                ]);
                $user->apiDataProject = json_decode($response3->getBody(), true);
            } catch (\Exception $e) {
                $user->apiDataProject = null;
            }

            // ตรวจสอบรูปภาพ
            $imgCheck = optional(optional($user->apiData)['data'])['img_check'];

            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
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
            // ตรวจสอบการค้นหาชื่อ
            // if (!$searchName || (isset($user->apiData['data']['name_th']) && stripos($user->apiData['data']['name_th'], $searchName) !== false)) {
            //     $filteredUsers->push($user);
            // }
        }
        //return $filteredUsers;
    }

    private function addApiDataToUsersPrinter($users)
    {
        $client = new Client();
        $apiUrl = env('API_URL');
        $apiToken = env('API_TOKEN');

        foreach ($users as $user) {
            try {
                $response = $client->request('GET', $apiUrl . '/users', [
                    'query' => ['user_id' => $user->user_id],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiToken,
                        'Accept' => 'application/json'
                    ]
                ]);
                $apiData = json_decode($response->getBody(), true);

                if ($apiData['status'] === 'success') {
                    $user->department_id = $apiData['data']['department_id'];
                    $user->department_name = $apiData['data']['department'];
                } else {
                    $user->department_id = null;
                    $user->department_name = 'Unknown';
                }
            } catch (\Exception $e) {
                $user->department_id = null;
                $user->department_name = 'Unknown';
            }
        }
    }



    private function addApiDataToDepartment()
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        try {
            $response = $client->request('GET', $apiUrl . '/departments', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Accept' => 'application/json'
                ]
            ]);

            $departmentData = json_decode($response->getBody(), true);

            if (isset($departmentData['data']) && is_array($departmentData['data'])) {
                return collect($departmentData['data']);
            } else {
                return collect([]);
            }
        } catch (\Exception $e) {
            return collect([]);
        }
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

        $loggedInUser = User::where('user_id', $request->session()->get('loginId'))->first();


        $userCounts = User::selectRaw('SUM(active = 1) as active_count, SUM(active = 0) as inactive_count')
            ->first();

        $query = User::select([
            'id', 'user_id', 'code', 'username', 'email', 'token', 'is_auth', 'active',
            'low_rise', 'high_rise', 'active_vbasset', 'active_report', 'active_agent',
            'active_vblead', 'active_vproject', 'active_printer', 'active_rental',
            'active_broker', 'active_vbis', 'created_date'
        ])->with([
            'role_report_ref:code_user,level',
            'role_report_refdb:code_user,db',
            'role_printer_ref:user_id,role_type,active',
            'role_rental_ref:user_id,role_type,active'
        ]);

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->orderBy('code', 'desc')->paginate(10);


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

    public function getUsersDisable(Request $request)
    {
        $loggedInUser = User::where('user_id', $request->session()->get('loginId'))->first();


        $userCounts = User::selectRaw('SUM(active = 1) as active_count, SUM(active = 0) as inactive_count')
            ->first();

        $query = User::with([
            'role_report_ref:code_user,level',
            'role_report_refdb:code_user,db',
            'role_printer_ref:user_id,role_type,active',
            'role_rental_ref:user_id,role_type,active'
        ]);

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->orderBy('code', 'desc')->where('active', 0)->paginate(10);

        // API
        $this->addApiDataToUsers($users);

        $departmentData = $this->addApiDataToDepartment();

        // dd($users);
        if ($loggedInUser->active_vbis == 1) {
            return view('users.disable', [
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
        $users = User::where('user_id', $request->user_id)->first();


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
        $Rprinter = RolePrinter::where('user_id', $request->user_id)->first();
        $Rrental = RoleRental::where('user_id', $request->user_id)->first();
        $RBoker = RoleBoker::where('user_id', $request->user_id)->first();
        $RReport = RoleReport::where('code_user', $request->user_id)->first();

        if ($request->role_system == "printer") {
            if ($Rprinter) {
                $Rprinter->role_type = $request->role_type;
                $Rprinter->save();
            } else {
                $Rprinter = new RolePrinter();
                $Rprinter->user_id = $request->user_id;
                $Rprinter->role_type = $request->role_type;
                $Rprinter->save();
            }
            return response()->json(['message' => 'อัพเดทเรียบร้อย']);
        } elseif ($request->role_system == "rental") {
            if ($Rrental) {
                $Rrental->role_type = $request->role_type;
                $Rrental->save();
            } else {
                $Rrental = new RoleRental();
                $Rrental->user_id = $request->user_id;
                $Rrental->role_type = $request->role_type;
                $Rrental->save();
            }
            return response()->json(['message' => 'อัพเดทเรียบร้อย']);
        } elseif ($request->role_system == "boker") {
            if ($RBoker) {
                $RBoker->role_type = $request->role_type;
                $RBoker->save();
            } else {
                $RBoker = new RoleBoker();
                $RBoker->user_id = $request->user_id;
                $RBoker->role_type = $request->role_type;
                $RBoker->save();
            }
            return response()->json(['message' => 'อัพเดทเรียบร้อย']);
        } elseif ($request->role_system == "report") {
            if ($RReport) {
                $RReport->level = $request->role_type;
                $RReport->password = $request->user_id;
                $RReport->save();
            } else {
                $RReport = new RoleReport();
                $RReport->code_user = $request->user_id;
                $RReport->level = $request->role_type;
                $RReport->save();
            }
            return response()->json(['message' => 'อัพเดทเรียบร้อย']);
        } elseif ($request->role_system == "reportdb") {
            if ($RReport) {
                $RReport->db = $request->role_type;
                $RReport->password = $request->user_id;
                $RReport->save();
            } else {
                $RReport = new RoleReport();
                $RReport->code_user = $request->user_id;
                $RReport->db = $request->role_type;
                $RReport->save();
            }
            return response()->json(['message' => 'อัพเดทเรียบร้อย']);
        } elseif ($request->role_system == "stock") {

            //dd($request->role_system );
            $url = env('APP_STOCK') . '/api/create-role/' . $request->user_id;
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('API_TOKEN_AUTH'),
            ])->post($url, [
                'role_type' => $request->role_type,
                'dept' => $request->dept,
            ]);

            //dd($response);

            if ($response->successful()) {

                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } else {

                return response()->json(['message' => 'ไม่สามารถอัพเดทข้อมูลได้']);
            }
        } elseif ($request->role_system == "project") {

            //dd($request->role_system );
            $url = env('APP_PROJECT') . '/api/create-role/' . $request->user_id;
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('API_TOKEN_AUTH'),
            ])->post($url, [
                'role_type' => $request->role_type,
            ]);

            //dd($response);
            if ($response->successful()) {

                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } else {

                return response()->json(['message' => 'ไม่สามารถอัพเดทข้อมูลได้']);
            }
        }


        return response()->json(['message' => 'error'], 404);
    }


    public function sendEmail(Request $request)
    {
        $user = User::with([
            'role_report_ref:code_user,level',
            'role_report_refdb:code_user,db',
            'role_printer_ref:user_id,role_type,active',
            'role_rental_ref:user_id,role_type,active'
        ])->where('user_id', $request->user_id)->first();

        if ($user) {
            $email = $user->email;

            Mail::to($email)->send(new AccessRoleSendMail($user));

            return response()->json(['message' => 'Email sent successfully!'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
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

            if ($deviceType == "Mobile") {
                return view('checkin.index', compact('data', 'checkIn', 'checkOut', 'dataCheckIn'));
            } else {
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

    public function print(Request $request)
    {
        $loggedInUser = User::where('user_id', $request->session()->get('loginId'))->first();

        $query = User::with([
            'role_report_ref:code_user,level',
            'role_report_refdb:code_user,db',
            'role_printer_ref:user_id,role_type,active',
            'role_rental_ref:user_id,role_type,active'
        ]);

        $users = $query->orderBy('code', 'desc')->get();

        // Add API data to users
        $this->addApiDataToUsersPrinter($users);

        // Get department data from API
        $departments = $this->addApiDataToDepartment();

        // Group users by department_id and include department names
        $groupedUsers = $users->groupBy('department_id')->map(function ($users, $departmentId) use ($departments) {
            $departmentName = $departments->firstWhere('department_id', $departmentId)['name'] ?? 'Unknown';

            return [
                'department_name' => $departmentName,
                'users' => $users
            ];
        });

        if ($loggedInUser->active_vbis == 1) {
            return view('users.printer', [
                'groupedUsers' => $groupedUsers,
            ]);
        } else {
            return back();
        }
    }



    public function testAPI(Request $request)
    {
        $stockApiUrl = env('APP_STOCK');
        $stockApiToken = env('API_TOKEN_AUTH');
        $projectApiUrl = env('APP_PROJECT');
        $projectApiToken = env('API_TOKEN_AUTH');
        $client = new Client();

        $response2 = $client->request('GET', $projectApiUrl . '/api/users-list/3464', [
            'headers' => [
                'Authorization' => 'Bearer ' . 'LcbxpDu7J2Dj2DkRlAKM6649tSSdwuJtKfcoSQhR'
            ]
        ]);
        //dd($response2);

        $apiDataStock = json_decode($response2->getBody(), true);

        return response()->json($apiDataStock);
    }

    public function testSendMail(Request $request)
    {

        $details = [
            'title' => 'Mail from Laravel 8',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::send([], [], function ($message) use ($details) {
            $message->to('santi.c@vbeyond.co.th')
                ->subject($details['title'])
                ->setBody('<h1>' . $details['title'] . '</h1><p>' . $details['body'] . '</p>', 'text/html');
        });

        return "Email Sent";
    }
}
