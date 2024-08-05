<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    private function addApiDataToUser($user)
    {
        $client = new Client();
        $apiUrl = config('services.external_api.url');
        $apiToken = config('services.external_api.token');
        $appHR = env('APP_HR');

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
            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
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

    public function createLogLogin(Request $request, $code, $system)
    {
        $checkSystems = ['vproject', 'stock', 'agent', 'hr'];

        if (in_array($system, $checkSystems)) {
            DB::table('vbeyond_report.log_login')->insert([
                'username' => $code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => $system
            ]);
        } else {
            return response()->json(['error' => 'Invalid system'], 400);
        }

        return response()->json(['message' => 'Log created successfully'], 200);
    }

    public function createUserbyHR(Request $request)
    {
        $userData = $request->all();
        $user = User::create($userData);
        if ($user) {
            Logs::addLog('system', 'API', 'API Create User: ' . $userData['code'] . ' ' . $userData['email'] . ' Success', 'System hr');
            return response()->json(['message' => 'User created successfully'], 200);
        } else {
            Logs::addLog('system', 'API', 'API Create User: ' . $userData['code'] . ' ' . $userData['email'] . ' Success', 'System hr');
            return response()->json(['message' => 'Failed to create user'], 500);
        }
    }

    public function resignUserbyHR(Request $request)
    {
        $userData = $request->all();
        $user = User::where('code', $userData['code'])->update([
            'active' => 0,
            'low_rise' => 0,
            'high_rise' => 0,
            'active_vbasset' => 0,
            'active_report' => 0,
            'active_agent' => 0,
            'active_vblead' => 0,
            'active_vproject' => 0,
            'active_printer' => 0,
            'active_rental' => 0,
            'active_vbis' => 0
        ]);

        if ($user) {
            Logs::addLog('system', 'API', 'API Resign User: ' . json_encode($userData) . ' Success', 'System hr');
            return response()->json(['message' => 'User updated successfully'], 200);
        } else {
            Logs::addLog('system', 'API', 'API Resign User: ' . json_encode($userData) . ' Success', 'System hr');
            return response()->json(['message' => 'Failed to update user'], 500);
        }
    }

    public function updateUserbyHR(Request $request)
    {
        $userData = $request->all();
        $user = User::where('user_id', $userData['user_id'])->update([
            'code' => $userData['code'],
            'email' => $userData['email'],
            'username' => $userData['code']
        ]);
        if ($user) {
            Logs::addLog('system', 'API', 'API Update Data User: ' . json_encode($userData) . ' Success', 'System hr');
            return response()->json(['message' => 'User updated successfully'], 200);
        } else {
            Logs::addLog('system', 'API', 'API Update Data User: ' . json_encode($userData) . ' Failed', 'System hr');
            return response()->json(['message' => 'Failed to update user'], 500);
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

    /////// project to agent db[report] //////
    public function getProject()
    {
        try {
            $data = [];
            $projects = DB::connection('mysql_report')->table('project')->get();
            //$data[0] = 'ทั้งหมด';

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

        try {
            $query = DB::connection('mysql_report')
                ->table('product')
                ->join('sale', 'sale.sid', '=', 'product.sid')
                ->leftJoin('project', 'product.project_id', '=', 'project.pid');

            if ($request->code || $request->old_code) {
                $query->where(function ($q) use ($request) {
                    $q->where('subid', $request->old_code)
                        ->orWhere('subid', $request->code);
                });
            }

            if ($request->bank && $request->bank != 'all') {
                $query->where('bank', $request->bank);
            }

            if ($request->project && $request->project != 'all') {
                $query->where('product.project_id', $request->project);
            }

            if ($request->roomno) {
                $query->where('RoomNo', 'LIKE', '%' . $request->roomno . '%');
            }


            if ($request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            if ($request->status) {
                $statusArray = is_array($request->status) ? $request->status : explode(',', $request->status);
                $query->whereIn('status', $statusArray);
            }

            if ($request->startdate && $request->enddate) {

                switch ($request->dt) {
                    case 'resultdate':
                        $query->whereBetween('resultdate', [$request->startdate, $request->enddate]);
                        break;
                    case 'receiveddate':
                        $query->whereBetween('receiveddate', [$request->startdate, $request->enddate]);
                        break;
                    case 'senddate':
                        $query->whereBetween('senddate', [$request->startdate, $request->enddate]);
                        break;
                    default:
                        $query->whereBetween('resultdate', [$request->startdate, $request->enddate]);
                        break;
                }
            }

            $data = $query->select('product.*', 'sale.name as team_name', 'project.Project_Name as project_name')->get();

            if ($data->isEmpty()) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }
    ///////////////////////////////////////////

    /////// project to stock db[rental] //////
    public function getProjectRent()
    {
        try {
            $projects = DB::connection('mysql_rental')
                ->table('projects')->select('pid as project_id', 'Project_Name')
                ->where('rent', 1)
                ->orderBy('Project_Name', 'asc')
                ->get();

            return response()->json(['data' => $projects], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }

    public function getStatusRoom()
    {
        try {
            $status = DB::connection('mysql_rental')
                ->table('rooms')->select('status_room')
                ->distinct()
                ->whereNotIn('status_room', ['', 'คืนห้อง'])
                ->orderBy('status_room', 'ASC')
                ->get();

            return response()->json(['data' => $status], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }

    public function searchRental(Request $request)
    {
        try {
            $rents = DB::connection('mysql_rental')
                ->table('rooms')->select(
                    'projects.Project_Name',
                    'rooms.id',
                    'rooms.pid',
                    'rooms.Create_Date',
                    'rooms.HomeNo',
                    'rooms.RoomNo',
                    'rooms.RoomType',
                    'rooms.Location',
                    'rooms.rental_status',
                    'rooms.Electric_Contract',
                    'rooms.Size',
                    'rooms.Owner',
                    'rooms.Status_Room',
                    'rooms.Phone',
                    'rooms.Phone as phone_owner',
                    'rooms.price',
                    'rooms.price as room_price',
                    'rooms.Trans_Status',
                    'rooms.contract_owner',
                    'rooms.Owner',
                    'rooms.Guarantee_Startdate',
                    'rooms.Guarantee_Enddate',
                    'rooms.date_firstrend',
                    'rooms.date_endrend',
                    'rooms.Other',
                    'customers.id as cid',
                    'customers.Contract_Status',
                    'customers.Contract_Startdate',
                    'customers.Contract_Enddate',
                    'customers.Cus_Name',
                    'customers.contract_cus',
                    'customers.Phone as phone_cus',
                    'customers.Price as price_cus'

                )
                ->from('rooms as rooms')
                ->join('projects', 'rooms.pid', '=', 'projects.pid')
                ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                    $join->on('rooms.pid', '=', 'customers.pid')
                        ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                        ->on('rooms.id', '=', 'customers.rid');
                })
                // ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
                ->where(function ($query) {
                    $query->where('rooms.Trans_Status', '=', '')
                        ->orWhereNull('rooms.Trans_Status');
                });

            if ($request->pid != 'all') {
                $rents->where('rooms.pid', $request->pid);
            }

            if ($request->Owner) {
                $rents->where('rooms.Owner', 'LIKE', '%' . $request->Owner . '%');
            }

            if ($request->RoomNo) {
                $rents->where('rooms.RoomNo', 'LIKE', '%' . $request->RoomNo . '%');
            }

            if ($request->HomeNo) {
                $rents->where('rooms.HomeNo', 'LIKE', '%' . $request->HomeNo . '%');
            }

            if ($request->Cusmoter) {
                $rents->where('customers.Cus_Name', 'LIKE', '%' . $request->Cusmoter . '%');
            }

            if ($request->typerent != 'all') {
                $rents->where('rooms.rental_status', $request->typerent);
            }

            if ($request->status != 'all') {
                if ($request->status == "เช่าอยู่") {
                    $rents->where('customers.Contract_Status', $request->status);
                } else {
                    $rents->where('rooms.Status_Room', $request->status);
                }
            } else {
                $rents->whereRaw("IFNULL(status_room, '') <> 'คืนห้อง'");
            }

            if ($request->dateselect && $request->startdate) {
                if ($request->dateselect == "transfer_date") {
                    if ($request->enddate != null) {
                        $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->enddate]);
                    } else {
                        $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->startdate]);
                    }
                } elseif ($request->dateselect == "Guarantee_Startdate") {
                    if ($request->enddate != null) {
                        $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->enddate]);
                    } else {
                        $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->startdate]);
                    }
                } elseif ($request->dateselect == "Guarantee_Enddate") {
                    if ($request->enddate != null) {
                        $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->enddate]);
                    } else {
                        $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->startdate]);
                    }
                } elseif ($request->dateselect == "Contract_Startdate") {
                    if ($request->enddate != null) {
                        $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->enddate]);
                    } else {
                        $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                    }
                } elseif ($request->dateselect == "Payment_date") {
                    $new_date = date('Y-m-d', strtotime($request->startdate . ' -1 year'));
                    $new_date = date('Y-m-01', strtotime($new_date));
                    if ($request->enddate != null) {
                        $rents->whereBetween('customers.Contract_Startdate', [$new_date, $request->enddate]);
                    } else {
                        $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                    }
                } elseif ($request->dateselect == "Cancle_Date") {
                    if ($request->enddate != null) {
                        $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->enddate]);
                    } else {
                        $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->startdate]);
                    }
                } else {
                    // $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
                    $rents->where('rooms.Create_Date', '<=', $request->enddate);
                    // $rents->where('rooms.Create_Date', '<=', '2024-06-21');
                }
            }

            // $rentsCount = $rents->count();

            $rents = $rents
                ->orderBy('Project_Name', 'asc')
                ->get();

            return response()->json(['data' => $rents], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error' => $e->getMessage()], 500);
        }
    }
    ///////////////////////////////////////////
}
