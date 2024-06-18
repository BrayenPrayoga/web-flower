<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = Transaksi::orderBy('id','ASC')->get();

        return view('transaksi', $data);
    }
    
    public function update(Request $request){
        $response = Transaksi::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }

    public function delete($id){
        $response = Transaksi::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }

    public function detailProduk(){
        $id = $_GET['id'];

        $detail_produk = DetailTransaksi::with('RelasiProduk')->where('id_transaksi', $id)->get();

        return $detail_produk;
    }
}
