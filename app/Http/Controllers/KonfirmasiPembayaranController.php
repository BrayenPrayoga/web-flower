<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonfirmasiPembayaran;

class KonfirmasiPembayaranController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = KonfirmasiPembayaran::orderBy('id','ASC')->get();

        return view('konfirmasi_pembayaran', $data);
    }
}
