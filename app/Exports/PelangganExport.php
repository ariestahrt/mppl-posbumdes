<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithProperties;

class PelangganExport implements FromArray, WithProperties
{
    public function properties(): array
    {
        return [
            'creator'        => 'TIM ICT KKN Desa Tihingan',
            'lastModifiedBy' => 'TIM ICT KKN Desa Tihingan',
            'title'          => 'Export Pelanggan',
            'description'    => 'Export Pelanggan',
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
            "Nama", "Alamat", "HP", "Total Transaksi", "Total Belanja", "Tanggal dibuat", "Terakhir diedit"
        ]);

        $all_pegawai = Pelanggan::all();
        foreach ($all_pegawai as $pel) {

            array_push($result, [
                $pel->nama, $pel->alamat, $pel->hp, strval($pel->total_belanja),
                strval($pel->total_transaksi), $pel->created_at, $pel->updated_at
            ]);
        }

        return [
            $result
        ];
    }
}
