<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\Roles;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Alamat	HP	Username	Role	Tanggal dibuat	Terakhir diedit

        $pegawai = Pegawai::create([
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'hp' => $row['hp'],
            'username' => $row['username'],
            'password' => Hash::make('123456'),
            'status' => $row['status'] == '1' ? true : false
        ]);

        $roles = explode(',' , $row['role']);
        foreach ($roles as $role) {
            Roles::create([
                'nama' => $role,
                'peg_id' => $pegawai->id
            ]);
        }

        return $pegawai;
    }
}
