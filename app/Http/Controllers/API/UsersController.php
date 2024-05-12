<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class UsersController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:api',['except'=>['store']]);
    }

    public function index(){
        $data['no'] = 1;
        $data['user'] = User::get();

        return view('users', $data);
    }

    public function store(Request $request){
        $response = User::storeModel($request);

        if($response['message'] == 'success'){
            return responseData($response['data']);
        }else{
            return [
                "meta" => ['code' => EC::HTTP_BAD_GATEWAY, 'message' => EM::HTTP_INTERNAL_SERVER_ERROR],
                "data" => $response['data']
            ];
        }
    }
    
    public function update(Request $request){
        $response = User::updateProfilModel($request);
        
        if($response['message'] == 'success'){
            return responseData($response['data']);
        }else{
            return [
                "meta" => ['code' => EC::HTTP_BAD_GATEWAY, 'message' => EM::HTTP_INTERNAL_SERVER_ERROR],
                "data" => $response['data']
            ];
        }
    }
}
