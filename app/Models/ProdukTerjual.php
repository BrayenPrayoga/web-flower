<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukTerjual extends Model
{
    use HasFactory;

    protected $table = 'produk_terjual';
    
    protected $guarded = [];
}
