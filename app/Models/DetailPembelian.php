<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    
    protected $table = "detail_transaksi_pembelian";

    protected $guarded = ['id'];
}