<?php

namespace App\Http\Controllers;

use App\Models\ReportLogin;
use App\Models\RolePrinter;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{

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


}
