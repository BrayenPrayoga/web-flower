<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = Transaksi::orderBy('id','ASC')->get();

        return view('transaksi', $data);
    }
}
