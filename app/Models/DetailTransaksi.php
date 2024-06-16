<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    
    protected $guarded = [];
}
