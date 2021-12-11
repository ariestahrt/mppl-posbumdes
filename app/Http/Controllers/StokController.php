<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use Carbon\Carbon;

class StokController extends Controller
{
    public function index()
    {
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $stok = Stok::where('status', 1)->get();

        return view("pages.manajemen-stok", [
            "stok" => $stok,
        ]);
    }

    // 
    public function api_get_historiStok($start, $end)
    {
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 24:00");
        
        $detailPembelian = DetailPembelian::whereBetween('created_at', [$startDate, $endDate])->get();
        $detailPenjualan = DetailPenjualan::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = [];
        foreach ($detailPembelian as $item) {
            // var_dump($item);
            array_push($data, [
                "tipe" => "B",
                "id" => $item->tra_id,
                "nama_barang" => $item->nama_barang,
                "kuantitas" => $item->kuantitas,
                "satuan" => $item->satuan,
                "harga" => $item->harga_beli,
                "total_belanja" => $item->harga_total_awal,
                "tanggal" => $item->created_at,
            ]);
        }
        foreach ($detailPenjualan as $item) {
            // var_dump($item);
            array_push($data, [
                "tipe" => "J",
                "id" => $item->tra_id,
                "nama_barang" => $item->nama_barang,
                "kuantitas" => $item->kuantitas,
                "satuan" => $item->satuan,
                "harga" => $item->harga_jual,
                "total_belanja" => $item->harga_total_awal,
                "tanggal" => $item->created_at,
            ]);
        }

        return json_encode($data);
    }

    // Get Stok
    public function get_stok($id){
        $stok_info = Stok::where('id', $id)->first();
        
        return json_encode(
            $stok_info
        );
    }

    // Get Semua Stok
    public function get_all_stok(){
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $all_stok = Stok::where('status', 1)->get();

        return json_encode(
            $all_stok
        );
    }

    // Update Stok Information
    public function update_stok_info(Request $request, $id)
    {
        // Update Data Stoknya
        $stok_to_update = Stok::where('id', $id);
        $stok_to_update->update([
            'stok'=> $request->stok
        ]);

        // Return JSON
        return json_encode([
            "error" => 0,
            "message" => "Update berhasil dilakukan"
        ]);
    }
}
