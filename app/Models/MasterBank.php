<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{
    use HasFactory;

    protected $table = 'master_bank';
    
    protected $guarded = [];

    public static function getModel(){
        try{
            $banner = MasterBank::get();

            $response = [];
            foreach($banner as $item){
                $data['id'] = $item->id;
                $data['jenis'] = $item->jenis;
                $data['nomer_rekening'] = $item->nomer_rekening;

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
                'jenis'             =>'required|max:50',
                'nomer_rekening'    =>'required'
            ]);

            $data = [
                'jenis'             => $request->jenis,
                'nomer_rekening'    => $request->nomer_rekening
            ];
            $banner = MasterBank::create($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'jenis'             =>'required|max:50',
                'nomer_rekening'    =>'required'
            ]);

            $data = [
                'jenis'             => $request->jenis,
                'nomer_rekening'    => $request->nomer_rekening
            ];
            $banner = MasterBank::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            MasterBank::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
