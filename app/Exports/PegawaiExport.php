<?php

namespace App\Exports;

use App\Models\Pegawai;
use App\Models\Roles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithProperties;

class PegawaiExport implements FromArray, WithProperties
{

    public function properties(): array
    {
        return [
            'creator'        => 'TIM ICT KKN Desa Tihingan',
            'lastModifiedBy' => 'TIM ICT KKN Desa Tihingan',
            'title'          => 'Export Pegawai',
            'description'    => 'Export Pegawai',
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
            "Nama", "Alamat", "HP", "Username", "Role", "Status", "Tanggal dibuat", "Terakhir diedit"
        ]);

        $all_pegawai = Pegawai::all();
        foreach ($all_pegawai as $peg) {
            $roles = Roles::where('peg_id', $peg->id)->get("nama");
            $roles_txt = "";
            $temp_counter = 0;

            foreach($roles as $role){
                $temp_counter++;
                $roles_txt .= $role->nama;
                if($temp_counter != count($roles)) $roles_txt .= ", ";
            }

            array_push($result, [
                $peg->nama, $peg->alamat, $peg->hp, $peg->username,
                $roles_txt, $peg->status ? '1' : '0',
                $peg->created_at, $peg->updated_at
            ]);
        }

        return [
            $result
        ];
    }
}
