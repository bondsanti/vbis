<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ApiController extends Controller
{


   public function getAuth(Request $request, $code)
   {

       $user = User::where('code', $code)->where('active',1)->first();

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

   private function addApiDataToUsers($users)
   {
       $client = new Client();
       $apiUrl = config('services.external_api.url');
       $apiToken = config('services.external_api.token');

       foreach ($users as $user) {
           try {
               $response = $client->request('GET', $apiUrl.'/users', [
                   'query' => ['user_id' => $user->id],
                   'headers' => [
                       'Authorization' => 'Bearer ' . $apiToken
                   ]
               ]);

               $user->apiData = json_decode($response->getBody(), true);

               $imgCheck = optional(optional($user->apiData)['data'])['img_check'];
               $remoteFile = $imgCheck ? "http://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
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

               $user->remoteFile = $remoteFile;
               $user->fileExists = $fileExists;

           } catch (\Exception $e) {

               //Log::error('API request failed for user ' . $user->id . ': ' . $e->getMessage());
               $user->apiData = null;
           }
       }
   }

}
