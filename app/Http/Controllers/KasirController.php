<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;


class KasirController extends Controller
{
    /* 
        Function call on page load
    */
    public function index()
    {
        $barang = Barang::where('status', 1)->get();
        $pelanggan = Pelanggan::where('status', 1)->get();

        return view("pages.kasir", [
            "barang" => $barang,
            "pelanggan" => $pelanggan,
        ]);
    }

    /* 
        Get Barang
    */
    public function get_barang($id){
        $barang_info = Barang::where('id', $id)->first();
        
        return json_encode(
            $barang_info
        );
    }

    /* 
        Get Semua Barang
    */
    public function get_all_barang(){
        $all_barang = Barang::where('status', 1)->get();

        return json_encode(
            $all_barang
        );
    }

    /* 
        Create Transaksi
    */
    public function create_transaksi(Request $request)
    {
        // Hitung dulu
        $total_belanja = 0;
        $total_bayar = $request->total_bayar;

        foreach ($request->list_barang as $barang) {
            $barang_in_db = Barang::where('kode_barang', $barang['kode_barang'])->first();
            $harga_in_db = $barang_in_db->harga_jual;

            $total_belanja += $barang['jumlah'] * $harga_in_db;
        };

        
        // Validasi Total Bayar
        if($total_bayar - $total_belanja < 0 && $request->status_bayar){
            return json_encode([
                "error" => 406,
                "message" => "Not Acceptable"
            ]);
        }

        // Validasi Stok Barang
        $list_barang = $request->list_barang;
        $stok_invalid = 0;
        $stok_invalid_msg = "";
        foreach ($list_barang as $barang) {
            $barang_in_db = Barang::where('kode_barang', $barang['kode_barang'])->first();
            if($barang_in_db->stok < $barang['jumlah']) {
                if($stok_invalid) $stok_invalid_msg .= ", ";
                $stok_invalid = 1;
                $stok_invalid_msg .= "" . $barang_in_db->nama_barang;
            }
        }
        if($stok_invalid) {
            return json_encode([
                "error" => 406,
                "message" => "Stok Barang \"".$stok_invalid_msg."\" Tidak Mencukupi"
            ]);
        }


        // Create Data Transaksi Penjualan
        $penjualan = Penjualan::create([
            'peg_id' => $request->peg_id,
            'pel_id' => $request->pel_id,
            'status_bayar' => $request->status_bayar,
            'total_belanja' => intval($total_belanja),
            'keterangan' => $request->keterangan,
            'total_bayar' => $total_bayar,
            'kembalian' => $total_bayar - $total_belanja
        ]);

        // Create Detail Transaksi Penjualan untuk Setiap Barang
        foreach ($list_barang as $barang) {
            $barang_in_db = Barang::where('kode_barang', $barang['kode_barang'])->first();
            $harga_in_db = $barang_in_db->harga_jual;
            DetailPenjualan::create([
                'sto_id'=> $barang['id'],
                'tra_id'=> $penjualan['id'],
                'nama_barang'=> $barang_in_db['nama_barang'],
                'satuan'=> $barang_in_db['satuan'],
                'harga_jual'=> $barang_in_db['harga_jual'],
                'kuantitas'=> $barang['jumlah'],
                'harga_total_awal'=> $barang['jumlah'] * $harga_in_db,
                'diskon'=> 0,
                'ppn'=> 0,
                'harga_total_akhir'=> $barang['jumlah'] * $harga_in_db,
            ]);

            $barang_in_db->update([
                'stok' => $barang_in_db->stok - $barang['jumlah']
            ]);
        };

        if(!($request->pel_id == null)) {
            $pelanggan_in_db = Pelanggan::where('id', $request->pel_id)->first();
            $pelanggan_in_db->update([
                'total_transaksi' => $pelanggan_in_db->total_transaksi + 1,
                'total_belanja' => $pelanggan_in_db->total_belanja + $total_belanja
            ]);
        }
        

        // Return JSON
        return json_encode([
            "error" => 0,
            "message" => "Update berhasil dilakukan",
            "id" => $penjualan['id']
        ]);
    }
}
