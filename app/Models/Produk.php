<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    
    protected $guarded = [];

    public static function getModel(){
        try{
            $id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : null;
            $produk = Produk::when($id_kategori, function($q, $id_kategori){
                $q->where('id_kategori', $id_kategori);
            })->get();

            $response = [];
            foreach($produk as $item){
                $data['produk'] = $item->produk;
                $data['gambar'] = asset('img_produk/'.$item->gambar);
                $data['deskripsi'] = $item->deskripsi;
                $data['harga'] = $item->harga;
                $data['stok'] = $item->stok;

                array_push($response, $data);
            }

            return ['message' => 'success', 'data' => $response];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public function RelasiKategori(){
        return $this->belongsTo(KategoriProduk::class,'id_kategori','id')->withDefault(['kategori'=>'']);
    }
    
    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'id_kategori' =>'required',
                'produk'    =>'required',
                'gambar'    =>'required',
                'deskripsi'    =>'required',
                'harga'    =>'required',
                'stok'    =>'required'
            ]);

            if($request->hasFile('gambar')){
                $file = $request->file('gambar');
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $path = public_path().'/img_produk';
                $file->move($path,$filename);
            }else{
                $filename = null;
            }

            $data = [
                'id_kategori'  => $request->id_kategori,
                'produk'       => $request->produk,
                'gambar'       => $filename,
                'deskripsi'    => $request->deskripsi,
                'harga'        => $request->harga,
                'stok'         => $request->stok,
                'created_at'   => date('Y-m-d H:i:s')
            ];
            $kategori = Produk::create($data);

            return ['message' => 'success', 'data' => $kategori];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'id_kategori' =>'required',
                'produk'    =>'required',
                'deskripsi' =>'required',
                'harga'     =>'required',
                'stok'      =>'required'
            ]);

            $produk = Produk::where('id', $request->id)->first();
            if($request->hasFile('gambar')){
                $file = $request->file('gambar');
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $path = public_path().'/img_produk';
                $file->move($path,$filename);
            }else{
                $filename = $produk->gambar;
            }

            $data = [
                'id_kategori'  => $request->id_kategori,
                'produk'       => $request->produk,
                'gambar'       => $filename,
                'deskripsi'    => $request->deskripsi,
                'harga'        => $request->harga,
                'stok'         => $request->stok,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $kategori = Produk::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $kategori];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            Produk::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
