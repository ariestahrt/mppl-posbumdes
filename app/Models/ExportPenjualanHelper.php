<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportPenjualanHelper extends Model
{
    use HasFactory;
    protected $table = 'export_penjualan_helper';
    protected $guarded = ['id'];
}
