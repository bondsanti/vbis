<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use RealRashid\SweetAlert\Facades\Alert;

class ApiController extends Controller
{
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
            //$remoteFile = $imgCheck ? "http://localhost/hr/imageUser/employee/{$imgCheck}" : null;
            $remoteFile = $imgCheck ? "http://vbhr.vbeyond.co.th/imageUser/employee/{$imgCheck}" : null;
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

    public function getAuth(Request $request, $code)
    {

        $user = User::where('code', $code)->where('active', 1)->first();

        if (!$user) {
            return response()->json(['message' => 'ไม่พบผู้ใช้งานระบบ'], 404);
        }

        $this->addApiDataToUser($user);


        return response()->json(['data' => $user], 200);
    }

    public function createLogLogin(Request $request, $code,$system)
    {
        if ($system=="vproject") {

            DB::table('vbeyond_report.log_login')->insert([
                'username' => $code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'vproject'
            ]);

        }elseif($system=="stock"){

            DB::table('vbeyond_report.log_login')->insert([
                'username' => $code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'stock'
            ]);

        }elseif($system=="agent"){
            DB::table('vbeyond_report.log_login')->insert([
                'username' => $code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'agent'
            ]);
        }elseif($system=="hr"){
            DB::table('vbeyond_report.log_login')->insert([
                'username' => $code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'hr'
            ]);
        }

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

    //GetName
    public function getNameUser($user_ids)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        try {
            $response = $client->request('GET', $apiUrl . '/users-public', [
                'query' => ['user_id' => $user_ids],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Accept' => 'application/json',
                ],
            ]);

            $apiData = json_decode($response->getBody(), true);


            return response()->json(['data' => $apiData], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to fetch data from external API'], 500);
        }
    }

    //get Name show Printer report
    public function getNameUserByCode($codes)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');

        try {
            $response = $client->request('GET', $apiUrl . '/code', [
                'query' => ['code' => $codes],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Accept' => 'application/json',
                ],
            ]);

            $apiData = json_decode($response->getBody(), true);


            return response()->json(['data' => $apiData], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to fetch data from external API'], 500);
        }
    }

    ///////////////////////////  get DB Report ///////////////////////////////
    public function getListAdmin()
    {
        //now()->toDateString()
        try {
            $data = DB::connection('mysql_report')
                ->table('product')
                ->join('sale', 'sale.sid', '=', 'product.sid')
                ->leftJoin('project', 'product.project_id', '=', 'project.pid')
                ->whereDate('resultdate', now()->toDateString())
                ->select('product.*', 'sale.name as team_name', 'project.Project_Name as project_name')
                ->get();

            if ($data->isEmpty()) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }


    public function getList($code, $old_code)
    {
        //now()->toDateString()
        try {
            $data = DB::connection('mysql_report')
                ->table('product')
                ->join('sale', 'sale.sid', '=', 'product.sid')
                ->leftJoin('project', 'product.project_id', '=', 'project.pid')
                ->whereDate('resultdate', now()->toDateString())
                ->where(function ($query) use ($code, $old_code) {
                    $query->where('subid', $old_code)
                          ->orWhere('subid', $code);
                })
                ->select('product.*', 'sale.name as team_name', 'project.Project_Name as project_name')
                ->get();

            if ($data->isEmpty()) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }

    }

    public function getListAll($code, $old_code)
    {
        try {
            $data = DB::connection('mysql_report')
                ->table('product')
                ->join('sale', 'sale.sid', '=', 'product.sid')
                ->leftJoin('project', 'product.project_id', '=', 'project.pid')
                ->where(function ($query) use ($code, $old_code) {
                    $query->where('subid', $old_code)
                          ->orWhere('subid', $code);
                })
                ->select('product.*', 'sale.name as team_name', 'project.Project_Name as project_name')
                ->get();

            if ($data->isEmpty()) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }


    public function getProject()
    {
        try {
            $data = [];
            $projects = DB::connection('mysql_report')->table('project')->get();
            $data[0] = 'ทั้งหมด';

            foreach ($projects as $value) {
                $data[$value->pid] = $value->Project_Name;
            }

            if (empty($projects)) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }

    public function getProduct(Request $request)
    {

        dd($request->all());

        try {
            $data = DB::connection('mysql_report')
                ->table('product')
                ->join('sale', 'sale.sid', '=', 'product.sid')
                ->leftJoin('project', 'product.project_id', '=', 'project.pid')
                ->where(function ($query) use ($code, $old_code) {
                    $query->where('subid', $old_code)
                          ->orWhere('subid', $code);
                })
                ->select('product.*', 'sale.name as team_name', 'project.Project_Name as project_name')
                ->get();

            if ($data->isEmpty()) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }




}
