<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StokImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check jika stoknya sudah ada dan statusnya 1
        // Maka jangan di import
        $check = Barang::where('status', 1)->where('kode_barang', $row['kode_barang'])->first();
        if($check){
            return $check; 
        }else{
            $stok = Barang::create([
                'kode_barang' => $row['kode_barang'],
                'nama_barang' => $row['nama_barang'],
                'satuan' => $row['satuan'],
                'harga_beli' => $row['harga_beli'],
                'harga_jual' => $row['harga_jual'],
                'stok' => $row['stok']
            ]);
            return $stok;
        }
    }
}
