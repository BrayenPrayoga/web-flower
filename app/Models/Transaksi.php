<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    
    protected $guarded = [];

    public static function getModel(){
        try{
            $no_order = isset($_GET['no_order']) ? $_GET['no_order'] : null;
            $konfirmasi = Transaksi::when($no_order, function($q, $no_order){
                $q->where('no_order', $no_order);
            })->get();

            $response = [];
            foreach($konfirmasi as $item){
                $data['id'] = $item->id;
                $data['no_order'] = $item->no_order;
                $data['bank_asal'] = $item->bank_asal;
                $data['bank_tujuan'] = $item->bank_tujuan;
                $data['metode'] = $item->metode;
                $data['nominal'] = $item->nominal;
                $data['tanggal'] = $item->tanggal;
                $data['bukti'] = 'img_bukti/'.$item->bukti;

                array_push($response, $data);
            }

            return ['message' => 'success', 'data' => $response];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'no_order'    =>'required|max:50',
                'total_harga'   =>'required|max:100'
            ]);

            $data = [
                'id_users'          => auth::user()->id,
                'no_order'          => $request->no_order,
                'status_transaksi'  => 0,
                'tanggal_transaksi' => date('Y-m-d H:i:s'),
                'total_harga_transaksi' => $request->total_harga_transaksi,
                'id_kupon'          => $request->id_kupon,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $store = Transaksi::create($data);

            $countProduk = count($request->id_produk);
            $i = 0;
            for($i ; $i < $countProduk ; $i++){
                $detail =[
                    'id_transaksi'  => $store->id,
                    'id_produk'     => $request->id_produk[$i],
                    'jumlah'        => $request->jumlah[$i],
                    'total_harga'   => $request->total_harga[$i],
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                DetailTransaksi::create($detail);
            }
            $data = $store;
            $data['detail'] = DetailTransaksi::where('id_transaksi', $store->id)->get();

            return ['message' => 'success', 'data' => $data];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'id'                =>'required',
                'status_transaksi'  =>'required'
            ]);
            $transaksi = Transaksi::where('id', $request->id)->update(['status_transaksi'=>$request->status_transaksi]);

            return ['message' => 'success', 'data' => $transaksi];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function deleteModal($id){
        try{
            $parent = Transaksi::where('id', $id)->delete();
            if($parent){
                DetailTransaksi::where('id_transaksi', $id)->delete();
            }

            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
