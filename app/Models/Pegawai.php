<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Model;


class Pegawai extends Model
{
    use HasFactory;
    protected $table = "pegawai";

    protected $fillable = [
        'nama',
        'alamat',
        'hp',
        'username',
        'password',
        'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword(){
        return $this->password;
    }

    public function roles()
    {
        return $this->hasMany(Roles::class, "peg_id");
    }
}
