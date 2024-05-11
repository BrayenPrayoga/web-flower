<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonfirmasiPembayaranController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }
}
