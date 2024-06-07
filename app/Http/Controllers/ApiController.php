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
}