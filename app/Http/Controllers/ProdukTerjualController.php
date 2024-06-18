<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProdukTerjualController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = Transaksi::where('status_transaksi', 2)->orderBy('id','ASC')->get();

        return view('produk_terjual', $data);
    }
}
