<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = "stok_produk";
    // protected $guarded = ['id'];
    protected $fillable = [
        'kode_barang',
        'status',
        'nama_barang',
        'satuan',
        'stok',
        'harga_beli',
        'harga_jual'
    ];
}
