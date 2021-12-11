<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function get_invoice_by_id_temp(){
        return view('pages.invoice2');
    }
    // Get Struct View by OrderID
    // /devs/invoice/{id}
    public function get_invoice_by_id($id){
        $penjualan = Penjualan::where('id', $id)->first();
        $penjualan_detail = DetailPenjualan::where('tra_id', $penjualan->id)->get();
        
        $tanggal_transaksi = $penjualan->created_at->format('d-m-Y - H:i:s');
        
        // return $penjualan_detail;
        $barang = [];
        $total = number_format($penjualan->total_belanja,0,',','.');
        $total_bayar = number_format($penjualan->total_bayar,0,',','.');
        $kembalian = number_format($penjualan->kembalian,0,',','.');
        foreach($penjualan_detail as $detail){
            array_push($barang, 
                [
                    "nama_barang" => $detail->nama_barang,
                    "kuantitas" => $detail->kuantitas." ".$detail->satuan,
                    "subtotal" => number_format($detail->harga_total_awal,0,',','.')

                ]
            );
        }

        // return $belanja;
        
        return view('pages.invoice', [
            'barang' => $barang,
            'tanggal' => $tanggal_transaksi,
            'total' => $total,
            'id_transaksi' => $id,
            'tunai' => $total_bayar,
            'kembali' => $kembalian
        ]);
    }
}
