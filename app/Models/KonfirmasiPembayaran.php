<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KonfirmasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_pembayaran';
    
    protected $guarded = [];

    public function RelasiUser(){
        return $this->belongsTo(User::class, 'id_users','id');
    }

    public static function getModel(){
        try{
            $no_order = isset($_GET['no_order']) ? $_GET['no_order'] : null;
            $konfirmasi = KonfirmasiPembayaran::where('id_users', auth::user()->id)->when($no_order, function($q, $no_order){
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
                'bank_asal'   =>'required|max:100',
                'bank_tujuan' =>'required|max:100',
                'metode'      =>'required|max:50',
                'nominal'     =>'required',
                'tanggal'     =>'required',
                'bukti'       =>'required|mimes:jpeg,jpg,png'
            ]);

            if($request->hasFile('bukti')){
                $file = $request->file('bukti');
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $path = public_path().'/img_bukti';
                $file->move($path,$filename);
            }else{
                $filename = null;
            }

            $data = [
                'id_users'      => auth::user()->id,
                'no_order'      => $request->no_order,
                'bank_asal'     => $request->bank_asal,
                'bank_tujuan'   => $request->bank_tujuan,
                'metode'        => $request->metode,
                'nominal'       => $request->nominal,
                'tanggal'       => $request->tanggal,
                'bukti'         => $filename,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $store = KonfirmasiPembayaran::create($data);

            return ['message' => 'success', 'data' => $store];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
