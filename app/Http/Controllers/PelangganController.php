<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Http\Requests\RequestStorePelanggan;

class PelangganController extends Controller
{
    public function index()
    {
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $pelanggan = Pelanggan::where('status', 1)->get();

        return view("pages.manajemen-pelanggan", [
            "pelanggan" => $pelanggan,
        ]);
    }

    // Create
    public function create(RequestStorePelanggan $request)
    {
        // dd($request->input());
        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);
        
        return json_encode([
            "error" => 0,
            "message" => "Pelanggan berhasil ditambahkan!"
        ]);
    }

    // Get Pelanggan
    public function get_pelanggan($id){
        $pelanggan_info = Pelanggan::where('id', $id)->first();
        
        return json_encode(
            $pelanggan_info
        );
    }

    // Get Semua Pelanggan
    public function get_all_pelanggan(){
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $all_pelanggan = Pelanggan::where('status', 1)->get();

        return json_encode(
            $all_pelanggan
        );
    }

    // Update Pelanggan Information
    public function update_pelanggan_info(Request $request, $id)
    {
        // Update Data Pelanggannya
        $pelanggan_to_update = Pelanggan::where('id', $id);
        $pelanggan_to_update->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
        ]);

        // Return JSON
        return json_encode([
            "error" => 0,
            "message" => "Update berhasil dilakukan"
        ]);
    }

    // Delete
    public function destroy($id)
    {
        $pelanggan = Pelanggan::where('id', $id)->first();
        $pelanggan->update([
            'status' => 0,
        ]);

        return json_encode([
            "error" => 0,
            "message" => "Berhasil menghapus pelanggan"
        ]);
    }
}
