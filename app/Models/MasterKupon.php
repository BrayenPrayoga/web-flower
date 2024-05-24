<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKupon extends Model
{
    use HasFactory;

    protected $table = 'master_kupon';
    
    protected $guarded = [];

    public static function cekKuponModel(){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d H:i:s");
            $kode = isset($_GET['kode']) ? $_GET['kode'] : null;

            $response = MasterKupon::where('status', 1)
                    ->where('tanggal_mulai','<=',$date)
                    ->where('tanggal_berakhir','>=',$date)
                    ->where('kode', $kode)
                    ->first();

            return ['message' => 'success', 'data' => $response];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'              =>'required|max:50',
                'kode'              =>'required|max:20',
                'kredit'            =>'required',
                'tanggal_mulai'     =>'required',
                'tanggal_berakhir'  =>'required',
                'status'            =>'required'
            ]);

            $data = [
                'nama'              => $request->nama,
                'kode'              => $request->kode,
                'kredit'            => $request->kredit,
                'tanggal_mulai'     => $request->tanggal_mulai,
                'tanggal_berakhir'  => $request->tanggal_berakhir,
                'status'            => $request->status,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $banner = MasterKupon::create($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'              =>'required|max:50',
                'kode'              =>'required|max:20',
                'kredit'            =>'required',
                'tanggal_mulai'     =>'required',
                'tanggal_berakhir'  =>'required',
                'status'            =>'required'
            ]);

            $data = [
                'nama'              => $request->nama,
                'kode'              => $request->kode,
                'kredit'            => $request->kredit,
                'tanggal_mulai'     => $request->tanggal_mulai,
                'tanggal_berakhir'  => $request->tanggal_berakhir,
                'status'            => $request->status,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $banner = MasterKupon::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            MasterKupon::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
