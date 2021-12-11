<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Requests\RequestStoreBarang;

class BarangController extends Controller
{
    public function index()
    {
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $barang = Barang::where('status', 1)->get();

        return view("pages.manajemen-barang", [
            "barang" => $barang,
        ]);
    }

    // Create
    public function create(RequestStoreBarang $request)
    {
        // dd($request->input());
        $barang = Barang::create([
            'sup_id'=> $request->sup_id,
            'kode_barang'=> $request->kode_barang,
            'nama_barang'=> $request->nama_barang,
            'satuan'=> $request->satuan,
            'harga_beli'=> $request->harga_beli,
            'harga_jual'=> $request->harga_jual,
        ]);
        
        return json_encode([
            "error" => 0,
            "message" => "Barang berhasil ditambahkan!"
        ]);
    }

    // Get Barang
    public function get_barang($id){
        $barang_info = Barang::where('id', $id)->first();
        
        return json_encode(
            $barang_info
        );
    }

    // Get Semua Barang
    public function get_all_barang(){
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $all_barang = Barang::where('status', 1)->get();

        return json_encode(
            $all_barang
        );
    }

    // Update Barang Information
    public function update_barang_info(Request $request, $id)
    {
        // Update Data Barangnya
        $barang_to_update = Barang::where('id', $id);
        $barang_to_update->update([
            'kode_barang'=> $request->kode_barang,
            'nama_barang'=> $request->nama_barang,
            'stok'=> $request->stok,
            'satuan'=> $request->satuan,
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
        $barang = Barang::where('id', $id)->first();
        $barang->update([
            "status" => 0,
        ]);
        $nama = $barang['nama_barang'];

        return json_encode([
            "error" => 0,
            "message" => "Berhasil menghapus barang $nama"
        ]);
    }
}
