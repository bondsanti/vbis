<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ApiController extends Controller
{


   // ระบบ Stock
   public function getRoleStock(Request $request, $code)
   {

       $user = User::where('code', $code)->first();


       if (!$user) {
           return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
       }

       return response()->json(['data' => $user], 200);
   }


   public function createUserbyHR(Request $request)
   {
    $userData = $request->all();
    $user = User::create($userData);
    if ($user) {
        return response()->json(['message' => 'User created successfully'], 200);
    } else {
        return response()->json(['message' => 'Failed to create user'], 500);
    }

   }

   //CheckToken
   public function checkTokenLogin(Request $request, $token)
   {

       $user = User::where('token', $token)->first();


       if (!$user) {
           return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
       }

       return response()->json(['data' => $user->token], 200);
   }

    //CheckTokenPublicWeb
   public function checkTokenPublicSite(Request $request, $token)
   {

       $user = User::where('token', $token)->first();


       if (!$user) {
           return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
       }

       return response()->json(['data' => $user], 200);
   }

}
