<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = KategoriProduk::orderBy('id','ASC')->get();

        return view('kategori_produk', $data);
    }

    public function store(Request $request){
        $response = KategoriProduk::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = KategoriProduk::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = KategoriProduk::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
