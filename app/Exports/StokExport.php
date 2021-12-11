<?php

namespace App\Exports;

use App\Models\Stok;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithProperties;

class StokExport implements FromArray, WithProperties
{
    public function properties(): array
    {
        return [
            'creator'        => 'TIM ICT KKN Desa Tihingan',
            'lastModifiedBy' => 'TIM ICT KKN Desa Tihingan',
            'title'          => 'Export Stok',
            'description'    => 'Export Stok',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => '',
        ];
    }

    public function array(): array
    {
        $result = [];
        // Set Heading
        array_push($result, [
            "kode_barang", "nama_barang", "satuan", "harga_beli", "harga_jual", "stok", "status", "Tanggal dibuat", "Terakhir diedit"
        ]);

        $all_stok = Stok::all();
        foreach ($all_stok as $stok) {

            array_push($result, [
                $stok->kode_barang,
                $stok->nama_barang,
                $stok->satuan,
                strval($stok->harga_beli),
                strval($stok->harga_jual),
                strval($stok->stok),
                strval($stok->status),
                $stok->created_at,
                $stok->updated_at
            ]);
        }

        return [
            $result
        ];
    }
}
