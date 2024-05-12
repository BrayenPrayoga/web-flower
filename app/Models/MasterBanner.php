<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBanner extends Model
{
    use HasFactory;

    protected $table = 'master_banner';
    
    protected $guarded = [];

    public static function getModel(){
        try{
            $banner = MasterBanner::where('status', 1)->get();

            $response = [];
            foreach($banner as $item){
                $data['id'] = $item->id;
                $data['keterangan'] = $item->keterangan;
                $data['gambar'] = asset('img_banner/'.$item->gambar);
                $data['created_at'] = $item->created_at;

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
                'keterangan'    =>'required',
                'gambar'        =>'required',
                'status'        =>'required'
            ]);

            if($request->hasFile('gambar')){
                $file = $request->file('gambar');
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $path = public_path().'/img_banner';
                $file->move($path,$filename);
            }else{
                $filename = null;
            }

            $data = [
                'keterangan'    => $request->keterangan,
                'gambar'        => $filename,
                'status'        => $request->status,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $banner = MasterBanner::create($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'keterangan'    =>'required',
                'status'        =>'required'
            ]);

            $item = MasterBanner::where('id', $request->id)->first();
            if($request->hasFile('gambar')){
                $file = $request->file('gambar');
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $path = public_path().'/img_banner';
                $file->move($path,$filename);
            }else{
                $filename = $item->gambar;
            }

            $data = [
                'keterangan'    => $request->keterangan,
                'gambar'        => $filename,
                'status'        => $request->status,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $banner = MasterBanner::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            MasterBanner::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
