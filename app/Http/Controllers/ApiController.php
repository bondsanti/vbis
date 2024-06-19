<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use RealRashid\SweetAlert\Facades\Alert;

class ApiController extends Controller
{


    public function getAuth(Request $request, $code)
    {

        $user = User::where('code', $code)->where('active', 1)->first();

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

        $user = User::where('token', $token)->select('token')->first();


        if (!$user) {
            return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
        }

        return response()->json(['data' => $user->token], 200);
    }

    public function getRoleUserAll($user_ids)
    {

        $userIdsArray = explode(',', $user_ids);

        $users = User::whereIn('user_id', $userIdsArray)
            ->select('user_id', 'code', 'email', 'token_forget', 'active', 'low_rise', 'high_rise', 'active_agent', 'active_vblead', 'active_vproject')
            ->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
        }

        return response()->json(['data' => $users], 200);
    }

    //CheckTokenPublicWeb
    public function checkTokenOut($token)
    {

        $user = User::where('token', $token)
            ->select(
                'user_id',
                'code',
                'email',
                'token',
                'token_forget',
                'is_auth',
                'active',
                'low_rise',
                'high_rise',
                'active_agent',
                'active_vblead',
                'active_vproject'
            )->first();

        if (!$user) {
            return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
        }

        $this->addApiDataToUser($user);

        return response()->json(['data' => $user], 200);
    }

    private function addApiDataToUser($user)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        try {
            $response = $client->request('GET', $apiUrl . '/users', [
                'query' => ['user_id' => $user->user_id],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);

            $apiData = json_decode($response->getBody(), true);
            $user->apiData = $apiData;

            // Check for image existence
            $imgCheck = optional(optional($apiData)['data'])['img_check'];
            $remoteFile = $imgCheck ? "http://localhost/hr/imageUser/employee/{$imgCheck}" : null;
            //$remoteFile = $imgCheck ? "http://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
            $fileExists = $this->checkRemoteFileExists($remoteFile);

            $user->remoteFile = $remoteFile;
            $user->fileExists = $fileExists;
        } catch (\Exception $e) {
            // Log::error('API request failed for user ' . $user->id . ': ' . $e->getMessage());
            $user->apiData = null;
        }
    }

    private function checkRemoteFileExists($url)
    {
        if (!$url) {
            return false;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($responseCode == 200);
    }
}
