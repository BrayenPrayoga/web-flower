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

    public function RelasiDetailTransaksi(){
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi','id');
    }
    
    public function RelasiKupon(){
        return $this->belongsTo(MasterKupon::class, 'id_kupon','id');
    }

    public static function getModel(){
        try{
            $no_order = isset($_GET['no_order']) ? $_GET['no_order'] : null;
            $status = isset($_GET['status']) ? $_GET['status'] : null;
            $konfirmasi = Transaksi::where('id_users' ,auth::user()->id)->with('RelasiDetailTransaksi','RelasiKupon')
            ->when($no_order, function($q, $no_order){
                $q->where('no_order', $no_order);
            })->when($status, function($q, $status){
                $q->where('status_transaksi', $status);
            })->get();

            $response = [];
            foreach($konfirmasi as $item){
                $data['id'] = $item->id;
                $data['no_order'] = $item->no_order;
                $data['status_transaksi'] = $item->status_transaksi;
                $data['tanggal_transaksi'] = $item->tanggal_transaksi;
                $data['total_harga_transaksi'] = $item->total_harga_transaksi;
                $data['alamat'] = $item->alamat;
                $data['id_kupon'] = $item->id_kupon;
                $data['kupon'] = $item->RelasiKupon;

                foreach($item->RelasiDetailTransaksi as $val){
                    $detail['id_produk'] = $val->id_produk;
                    $detail['produk'] = $val->RelasiProduk->produk;
                    $detail['gambar'] = 'img_produk/'.$val->RelasiProduk->gambar;
                    $detail['jumlah'] = $val->jumlah;
                    $detail['total_harga'] = $val->total_harga;

                    $data['detail_transaksi'][] = $detail;
                }
                array_push($response, $data);
                $data['detail_transaksi'] = [];
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
                'total_harga_transaksi'   =>'required|max:100',
                'alamat'   =>'required'
            ]);

            $count_transaksi = Transaksi::where('id_users', auth::user()->id)->count();
            if($count_transaksi == 0){ 
                $no_order = 'ZF0000'. $count_transaksi + 1;
            }elseif($count_transaksi > 0 && $count_transaksi < 9){ 
                $no_order = 'ZF0000'. $count_transaksi + 1;
            }elseif($count_transaksi > 9 && $count_transaksi < 99){ // puluhan
                $no_order = 'ZF000'. $count_transaksi + 1;
            }elseif($count_transaksi > 99 && $count_transaksi < 999){ // ratusan
                $no_order = 'ZF00'. $count_transaksi + 1;
            }elseif($count_transaksi > 999 && $count_transaksi < 9999){ // ribuan
                $no_order = 'ZF0'. $count_transaksi + 1;
            }elseif($count_transaksi > 9999 && $count_transaksi < 99999){ // puluhan ribu
                $no_order = 'ZF'. $count_transaksi + 1;
            }else{
                $no_order = 'ZF'. $count_transaksi + 1;
            }
            $data = [
                'id_users'          => auth::user()->id,
                'no_order'          => $no_order,
                'status_transaksi'  => 0,
                'tanggal_transaksi' => date('Y-m-d H:i:s'),
                'total_harga_transaksi' => $request->total_harga_transaksi,
                'id_kupon'          => $request->id_kupon,
                'alamat'          => $request->alamat,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $store = Transaksi::create($data);

            $countProduk = count($request->id_produk);
            $i = 0;
            for($i ; $i < $countProduk ; $i++){
                Checkout::where('id_users', auth::user()->id)->where('id_produk', $request->id_produk[$i])->delete();
                $detail =[
                    'id_transaksi'  => $store->id,
                    'id_produk'     => $request->id_produk[$i],
                    'jumlah'        => $request->jumlah[$i],
                    'total_harga'   => $request->total_harga[$i],
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                DetailTransaksi::create($detail);

                //Kurangin Stok produk
                $produk = Produk::where('id', $request->id_produk[$i])->first();
                $stok = $produk->stok - $request->jumlah[$i];
                Produk::where('id', $request->id_produk[$i])->update(['stok'=>$stok]);
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
            $transaksi = Transaksi::where('id', $request->id)->update([
                'status_transaksi' => $request->status_transaksi,
                'keterangan'       => $request->keterangan
            ]);

            //Tambahin Stok produk
            $transaksi = Transaksi::with('RelasiDetailTransaksi')->where('id', $request->id)->get();
            foreach($transaksi as $item){
                foreach($item->RelasiDetailTransaksi as $val){
                    $produk = Produk::where('id', $val->id_produk)->first();
                    $stok = $produk->stok + $val->jumlah;
                    Produk::where('id', $val->id_produk)->update(['stok'=>$stok]);
                }
            }

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
