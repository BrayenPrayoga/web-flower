<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Foreach_;

class KategoriProduk extends Model
{
    use HasFactory;
    
    protected $table = 'kategori_produk';
    
    protected $guarded = [];

    public static function getModel(){
        try{
            $kategori = KategoriProduk::with('RelasiProduk')->get();

            $response = [];
            foreach($kategori as $item){
                $data['id'] = $item->id;
                $data['kategori'] = $item->kategori;

                foreach($item->RelasiProduk as $val){
                    $produk['id_produk'] = $val->id;
                    $produk['produk'] = $val->produk;
                    $produk['gambar'] = 'img_produk/'.$val->gambar;
                    $produk['deskripsi'] = $val->deskripsi;
                    $produk['harga'] = $val->harga;
                    $produk['stok'] = $val->stok;

                    $data['produk'][] = $produk;
                }
                array_push($response, $data);
                $data['produk'] = [];
            }

            return ['message' => 'success', 'data' => $response];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public function RelasiProduk(){
        return $this->hasMany(Produk::class, 'id_kategori','id');
    }
    
    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'kategori'    =>'required|max:50'
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
                'kategori'    =>'required|max:50'
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
