<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return response()->json([
                        'success' => true,
                        'user'    => Auth::guard('api')->user(),    
                        'token'   => $token   
                    ], 200);
        } else {
            return [
                "meta" => ['code' => EC::HTTP_BAD_GATEWAY, 'message' => EM::HTTP_INTERNAL_SERVER_ERROR],
                "data" => []
            ];
        }

    }

    public function logout(Request $request){
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
  
}
