<?php

namespace App\Http\Controllers\API;

use App\Models\MasterKupon;
use App\Http\Controllers\Controller;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class MasterKuponController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){
        $response = MasterKupon::cekKuponModel();
        
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
