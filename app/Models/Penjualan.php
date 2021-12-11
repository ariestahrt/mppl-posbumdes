<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = "transaksi_penjualan";

    protected $guarded = ['id'];

    // protected $fillable = [
    //     'peg_id',
    //     'pel_id',
    //     'status_bayar'
    // ];
}
