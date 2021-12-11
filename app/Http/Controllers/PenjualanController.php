<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    /* 
    //  Function call on page load
    */
    public function index()
    {
        return view("pages.penjualan");
    }

    /*
    // Populate datatables based on date
    */
    public function api_get_penjualan($start, $end){

        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 23:59");
        
        $penjualan = Penjualan::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = [];
        
        foreach ($penjualan as $item) {
            // var_dump($item);
            $pegawai = Pegawai::select('nama')->where('id', $item->peg_id)->first();
            array_push($data, [
                "id" => $item->id,
                "pegawai" => $pegawai->nama,
                "total_belanja" => $item->total_belanja,
                "total_bayar" => $item->total_bayar,
                "kembalian" => $item->kembalian,
                "status_bayar" => $item->status_bayar,
                "keterangan" => $item->keterangan,
                "tanggal" => $item->created_at,
            ]);
        }

        return json_encode($data);
    }

    /*
    // Get Penjualan Information
    */
    public function api_get_penjualan_bon($id){
        $penjualan = Penjualan::where("id", $id)->first();

        $data = [
            "id" => $penjualan->id,
            "total_belanja" => $penjualan->total_belanja,
            "total_bayar" => $penjualan->total_bayar,
            "kembalian" => $penjualan->kembalian,
            "keterangan" => $penjualan->keterangan,
        ];
        

        return json_encode($data);
    }

    /*
    // Update Bon Penjualan Information
    */
    public function api_get_penjualan_update_bon(Request $request){
        $penjualan = Penjualan::where("id", $request->id)->first();

        $total_terbayar = $penjualan->total_bayar + $request->pembayaran;

        // dd($request);

        Penjualan::where("id", $request->id)->update([
            "total_bayar" => $total_terbayar,
            "kembalian" => $total_terbayar - $penjualan->total_belanja,
            "keterangan" => $request->keterangan,
        ]);

        if ($total_terbayar >= $penjualan->total_belanja) {
            Penjualan::where("id", $request->id)->update([
                "status_bayar" => 1,
            ]);
        }

        return json_encode([
            "error" => 0,
            "message" => "Berhasil Mengedit Stok",
        ]);
    }
}
