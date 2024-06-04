<?php

namespace App\Http\Controllers;

use App\Models\ReportLogin;
use App\Models\RolePrinter;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $query = User::with('role_report_ref:code_user,level', 'role_printer_ref:user_id,role_type,active');


        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('name')) {
            $query->where('name_th', 'like', '%' . $request->name . '%');
        }

        $users = $query->orderBy('code', 'desc')->paginate(10);
        // สร้าง Guzzle client
        $client = new Client();

        // วนลูปผ่าน $users เพื่อดึงข้อมูลจาก API สำหรับแต่ละผู้ใช้
        foreach ($users as $user) {
            $response = $client->request('GET', 'http://vbhr.vbeyond.co.th/api/users/id/index.php', [
                'query' => ['user_id' => $user->id],
                'headers' => [
                    'Authorization' => 'Bearer qN4V4myt6fjlSraGgRU23|b6zKTOXTpeEvcZIH5Qi'
                ]
            ]);

            $apiData = json_decode($response->getBody(), true);
            $user->apiData = $apiData;
        }
        //dd($users);
        return view(
            'users.index',
            compact(
                'users',
            )
        );
    }
    // public function getUsers(Request $request)
    // {
    //     $query = User::with('role_report_ref:code_user,level', 'role_printer_ref:user_id,role_type,active');

    //     if ($request->filled('code')) {
    //         $query->where('code', 'like', '%' . $request->code . '%');
    //     }

    //     if ($request->filled('email')) {
    //         $query->where('email', 'like', '%' . $request->email . '%');
    //     }

    //     // Fetch users without name_th filter for now
    //     $users = $query->orderBy('code', 'desc')->get();

    //     // Create Guzzle client
    //     $client = new Client();

    //     // Array to hold users with name_th data
    //     $filteredUsers = [];

    //     // Loop through $users to get data from API for each user
    //     foreach ($users as $user) {
    //         $response = $client->request('GET', 'http://vbhr.vbeyond.co.th/api/users/id/index.php', [
    //             'query' => ['user_id' => $user->id],
    //             'headers' => [
    //                 'Authorization' => 'Bearer qN4V4myt6fjlSraGgRU23|b6zKTOXTpeEvcZIH5Qi'
    //             ]
    //         ]);

    //         $apiData = json_decode($response->getBody(), true);
    //         $user->apiData = $apiData; // Assign the entire API response

    //         // Apply the name_th filter if the name is provided in the request
    //         if (!$request->filled('name') || stripos(optional($apiData)['name_th'], $request->name) !== false) {
    //             $filteredUsers[] = $user;
    //         }
    //     }

    //     // Create a paginator manually since we filtered the users array
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $perPage = 10;
    //     $currentPageItems = array_slice($filteredUsers, ($currentPage - 1) * $perPage, $perPage);
    //     $paginatedUsers = new LengthAwarePaginator($currentPageItems, count($filteredUsers), $perPage, $currentPage, [
    //         'path' => LengthAwarePaginator::resolveCurrentPath(),
    //         'query' => $request->query(),
    //     ]);

    //     return view('users.index', ['users' => $paginatedUsers]);
    // }


    public function updateActive(Request $request)
    {
        $users = User::findOrFail($request->user_id);


        if ($users) {

            if ($request->active_type == "report") {
                $users->active_report = $request->active;
                $users->save();
                return response()->json(['message' => 'อัพเดทเรียบร้อย']);
            } elseif ($request->active_type == "printer") {
                $users->active_printer = $request->active;
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
}
