<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    
    public function getJWTCustomClaims(){
        return [];
    }

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'      =>'required',
                'email'     =>'required',
                'password'  =>'required',
                'role'      =>'required'
            ]);

            $data = [
                'name'          => $request->nama,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'status'        => $request->role,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $user = User::create($data);

            return ['message' => 'success', 'data' => $user];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'      =>'required',
                'email'     =>'required',
                'role'      =>'required'
            ]);

            $password = User::where('id', $request->id)->first();

            $data = [
                'name'          => $request->nama,
                'email'         => $request->email,
                'password'      => ($request->password) ? Hash::make($request->password) : $password->password,
                'status'        => $request->role,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $user = User::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $user];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            User::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    
    public static function updateProfilModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'      =>'required',
                'email'     =>'required',
            ]);

            $password = User::where('id', auth::user()->id)->first();

            $data = [
                'name'          => $request->nama,
                'email'         => $request->email,
                'password'      => ($request->password) ? Hash::make($request->password) : $password->password,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            User::where('id', auth::user()->id)->update($data);

            return ['message' => 'success', 'data' => auth::user()];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
