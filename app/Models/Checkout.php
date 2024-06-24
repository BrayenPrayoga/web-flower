<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkout';
    
    protected $guarded = [];
    
    public function RelasiUser(){
        return $this->belongsTo(User::class, 'id_users','id');
    }

    public function RelasiProduk(){
        return $this->belongsTo(Produk::class,'id_produk','id')->withDefault(['produk'=>'']);
    }

    public static function getModel(){
        try{
            $id_users = auth::user()->id;
            $response = Checkout::with('RelasiProduk')->where('id_users', $id_users)->get();

            return ['message' => 'success', 'data' => $response];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'id_produk'    =>'required',
                'jumlah'       =>'required'
            ]);

            $data = [
                'id_users'          => auth::user()->id,
                'id_produk'         => $request->id_produk,
                'jumlah'            => $request->jumlah,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $store = Checkout::create($data);

            return ['message' => 'success', 'data' => $store];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $id_users = auth::user()->id;

            $request->validate([
                'jumlah'       =>'required'
            ]);

            $data = [
                'jumlah'            => $request->jumlah,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $update = Checkout::where('id', $request->id)->where('id_users', $id_users)->update($data);
            if($update){
                return ['message' => 'success', 'data' => 'Update Berhasil'];
            }else{
                return ['message' => 'error', 'data' => 'Update Gagal'];
            }
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function deleteModal($id){
        try{
            $id_users = auth::user()->id;
            if(!empty($id)){
                Checkout::where('id', $id)->where('id_users', $id_users)->delete();

                return ['message' => 'success', 'data' => 'Berhasil Hapus'];
            }else{
                return ['message' => 'error','data' => 'ID Tidak Boleh Kosong'];
            }
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
