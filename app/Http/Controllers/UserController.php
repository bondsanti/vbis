<?php

namespace App\Http\Controllers;

use App\Models\ReportLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getUserSignInByYear(Request $request, $year)
    {
        if ( $year != "All") {

            $dataSign = ReportLogin::whereRaw("YEAR(dates) = ?", [$year])
            ->where('page', '<>', 'LoginPage')
            ->distinct(['username', 'page', 'dates'])
            ->get();

        }else{
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
}
