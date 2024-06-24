<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Http\Controllers\Controller;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class CheckoutController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:api');
    }
    
    public function index(){
        $response = Checkout::getModel();
        
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
        $response = Checkout::storeModel($request);
        
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
        $response = Checkout::updateModel($request);
        
        if($response['message'] == 'success'){
            return responseData($response['data']);
        }else{
            return [
                "meta" => ['code' => EC::HTTP_BAD_GATEWAY, 'message' => EM::HTTP_INTERNAL_SERVER_ERROR],
                "data" => $response['data']
            ];
        }
    }
    
    public function delete(){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $response = Checkout::deleteModal($id);
        
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
