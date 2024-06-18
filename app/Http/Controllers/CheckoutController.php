<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = Checkout::orderBy('id','ASC')->get();

        return view('checkout', $data);
    }
}
