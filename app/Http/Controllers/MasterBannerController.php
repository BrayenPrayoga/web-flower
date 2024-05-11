<?php

namespace App\Http\Controllers;

use App\Models\MasterBanner;
use Illuminate\Http\Request;

class MasterBannerController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = MasterBanner::orderBy('id','ASC')->get();

        return view('master_banner', $data);
    }

    public function store(Request $request){
        $response = MasterBanner::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = MasterBanner::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = MasterBanner::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
