<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToModel, WithHeadingRow
{

    // Nama	Alamat	HP

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $pelanggan = Pelanggan::create([
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'hp' => $row['hp'],
        ]);

        return $pelanggan;
    }
}
