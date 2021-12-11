<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Pegawai;
use App\Models\DetailPembelian;
use App\Http\Requests\RequestStorePembelian;
use Carbon\Carbon;

class PembelianController extends Controller
{
    /* 
    // Get Pembelian Data to Display
    */
    public function index_pembelian()
    {
        return view("pages.pembelian");
    }



    /*
    // Populate datatables based on date
    */
    public function api_get_pembelian($start, $end){
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 24:00");
        
        $pembelian = Pembelian::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = [];
        
        foreach ($pembelian as $item) {
            // var_dump($item);
            $pegawai = Pegawai::select('nama')->where('id', $item->peg_id)->first();
            array_push($data, [
                "id" => $item->id,
                "pegawai" => $pegawai->nama,
                "total_belanja" => $item->total_belanja,
                "tanggal" => $item->created_at,
            ]);
        }

        return json_encode($data);
    }



    /*
    // Populate datatables based on date
    */
    public function api_get_detail_pembelian($idTrans){
        
        $detPembelian = DetailPembelian::where('tra_id', $idTrans)->get();

        $data = [];
        
        foreach ($detPembelian as $item) {
            array_push($data, [
                "id" => $item->id,
                "nama_barang" => $item->nama_barang,
                "satuan" => $item->satuan,
                "kuantitas" => $item->kuantitas,
                "harga_beli" => $item->harga_beli,
                "harga_total" => $item->harga_total_akhir,
                "tanggal" => $item->created_at,
            ]);
        }

        return json_encode($data);
    }


    /*
    // Get data of detail pembelian with transaction id $id
    */
    public function get_detail_pembelian($id) {
        $detailPembelian = DetailPembelian::where('tra_id', $id)->get();

        return view('pages.detail-pembelian', [
            "detailPembelian" => $detailPembelian,
            "id" => $id,
        ]);
    }



    /*
    // Update pembelian data
    */
    public function api_update_pembelian(Request $request, $id) {
        $detailPembelian = DetailPembelian::where('id', $id)->first();
        $detailPembelian->update([
            'kuantitas'=> $request->jumlah,
            'harga_beli'=> $request->harga,
            'harga_total_awal'=> $request->jumlah * $request->harga,
            'harga_total_akhir'=> $request->jumlah * $request->harga,
        ]);

        $listDetailPembelian = DetailPembelian::where('tra_id', $detailPembelian->tra_id)->get();

        $total = 0;
        foreach ($listDetailPembelian as $item) {
            $total += $item->harga_total_akhir;
        }

        Pembelian::where('id', $detailPembelian->tra_id)->update([
            'total_belanja' => $total,
            'total_bayar' => $total
        ]);
        
        return json_encode([
            "error" => 0,
            "message" => $request->jumlah * $request->harga
        ]);
    }





    /* 
    // TAMBAH TRANSAKSI PEMBELIAN PAGE
    */
    public function index_tambah_pembelian()
    {
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $barang = Barang::where('status', 1)->get();

        return view("pages.tambah_pembelian", [
            "barang" => $barang,
        ]);
    }

    public function api_create_pembelian(Request $request)
    {
        // Hitung dulu
        $total_belanja = $request->total_belanja;
        $list_barang = $request->list_barang;

        // Create Data Transaksi Penjualan
        $pembelian = Pembelian::create([
            'peg_id' => $request->peg_id,
            'nama_supplier' => '',
            'status_bayar' => $request->status_bayar,
            'total_belanja' => intval($total_belanja),
            'total_bayar' => intval($total_belanja),
            'kembalian' => intval(0),
        ]);

        // Create Detail Transaksi Penjualan untuk Setiap Barang
        foreach ($list_barang as $barang) {
            $barang_in_db = Barang::where('kode_barang', $barang['kode_barang'])->first();
            DetailPembelian::create([
                'sto_id'=> $barang_in_db['id'],
                'nama_barang'=> $barang_in_db['nama_barang'],
                'tra_id'=> $pembelian->id,
                'kuantitas'=> $barang['jumlah'],
                'satuan'=> $barang['satuan'],
                'harga_beli'=> $barang['harga_beli'],
                'harga_total_awal'=> $barang['jumlah'] * $barang['harga_beli'],
                'diskon'=> 0,
                'ppn'=> 0,
                'harga_total_akhir'=> $barang['jumlah'] * $barang['harga_beli'],
            ]);

            $barang_in_db->update([
                'stok' => $barang_in_db->stok + $barang['jumlah']
            ]);
        };
        

        // Return JSON
        return json_encode([
            "error" => 0,
            "message" => "Pembelian Berhasil Ditambahkan"
        ]);
    }
}