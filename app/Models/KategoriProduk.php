<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;
    
    protected $table = 'kategori_produk';
    
    protected $guarded = [];
    
    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'kategori'    =>'required'
            ]);

            $data = [
                'kategori'    => $request->kategori,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $kategori = KategoriProduk::create($data);

            return ['message' => 'success', 'data' => $kategori];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'kategori'    =>'required'
            ]);

            $data = [
                'kategori'    => $request->kategori,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $kategori = KategoriProduk::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $kategori];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            KategoriProduk::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
