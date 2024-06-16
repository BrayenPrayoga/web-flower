<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Http\Controllers\Controller;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class TransaksiController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){
        $response = Transaksi::getModel();
        
        if($response['message'] == 'success'){
            return responseData($response['data']);
        }else{
            return [
                "meta" => ['code' => EC::HTTP_BAD_GATEWAY, 'message' => EM::HTTP_INTERNAL_SERVER_ERROR],
                "data" => $response['data']
            ];
        }
    }
    
    public function store(Request $request){
        $response = Transaksi::storeModel($request);
        
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
