<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportHelper extends Model
{
    use HasFactory;
    protected $table = "export_helper";
    protected $guarded = ['id'];
}
