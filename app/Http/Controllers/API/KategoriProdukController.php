<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class KategoriProdukController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){
        $response = KategoriProduk::getModel();
        
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
