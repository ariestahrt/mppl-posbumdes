<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PegawaiExport;
use App\Exports\PelangganExport;
use App\Exports\PenjualanExport;
use App\Exports\StokExport;
use App\Imports\PegawaiImport;
use App\Imports\PelangganImport;
use App\Imports\StokImport;
use Excel;
use Exception;
use Carbon\Carbon;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\ExportPenjualanHelper;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ImportExportController extends Controller
{
    public function ExportPegawai() 
    {

        return Excel::download(new PegawaiExport, 'Export-Pegawai-'.date("Y-m-d h:i:s").'.xlsx');
    }

    public function ImportPegawai(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try{
            Excel::import(new PegawaiImport, $request->file);
            return json_encode([
                "error" => 0,
                "message" => "Berhasil melakukan import"
            ]);
        }catch(Exception $e){
            return json_encode([
                "error" => 1,
                "message" => "Terjadi kesalahan dalam melakukan import, informasi lebih lengkap terdapat pada dokumentasi",
                // "details" => addslashes($e->__toString())
            ]);
        }
    }

    public function ExportPelanggan() 
    {
        return Excel::download(new PelangganExport, 'Export-Pelanggan-'.date("Y-m-d h:i:s").'.xlsx');
    }

    public function ImportPelanggan(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try{
            Excel::import(new PelangganImport, $request->file);
            return json_encode([
                "error" => 0,
                "message" => "Berhasil melakukan import"
            ]);
        }catch(Exception $e){
            return json_encode([
                "error" => 1,
                "message" => "Terjadi kesalahan dalam melakukan import, informasi lebih lengkap terdapat pada dokumentasi",
                "details" => addslashes($e->__toString())
            ]);
        }
    }

    public function ExportStok() 
    {
        return Excel::download(new StokExport, 'Export-Stok-'.date("Y-m-d h:i:s").'.xlsx');
    }

    public function ImportStok(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try{
            Excel::import(new StokImport, $request->file);
            return json_encode([
                "error" => 0,
                "message" => "Berhasil melakukan import"
            ]);
        }catch(Exception $e){
            return json_encode([
                "error" => 1,
                "message" => "Terjadi kesalahan dalam melakukan import, informasi lebih lengkap terdapat pada dokumentasi",
                "details" => addslashes($e->__toString())
            ]);
        }
    }

    // Export Penjualan
    public function ExportPenjualan($start, $end){
        // Export hanya bisa dilakukan pada bulan yang sama
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 23:59");
        
        // return $endDate->format('d');
        // return intval($endDate->format('d'));

        ExportPenjualanHelper::truncate();

        $penjualan = Penjualan::where('status_bayar', 1)->whereBetween('created_at', [$startDate, $endDate])->get();
        foreach($penjualan as $transaksi){
            $detail_penjualan = DetailPenjualan::where('tra_id', $transaksi->id)->get();
            foreach($detail_penjualan as $barang){
                $barang_id = $barang->sto_id;
                $kuantitas = $barang->kuantitas;

                $barang_in_helper = null;

                $tanggal_transaksi = intval($transaksi->created_at->format('d'));
                
                if (ExportPenjualanHelper::where('id_barang', $barang_id)->exists()) {
                    // update isinya
                    $barang_in_helper = ExportPenjualanHelper::where('id_barang', $barang_id)->first();
                    
                    $barang_in_helper->increment('d'.strval($tanggal_transaksi), $kuantitas);
                    $barang_in_helper->increment('jumlah_barang', $kuantitas);
                }else{
                    // Get Barang
                    $barang_from_db = Barang::where('id', $barang_id)->first();
                    // if(!$barang_from_db) return $detail_penjualan;
                    // return $barang_from_db;

                    $barang_in_helper = ExportPenjualanHelper::create([
                        'id_barang' => $barang->id,
                        'kode_barang' => $barang_from_db->kode_barang,
                        'nama_barang' => $barang_from_db->nama_barang,
                        'satuan' => $barang_from_db->satuan,
                        'd'.strval($tanggal_transaksi) => $kuantitas,
                        'jumlah_barang' => $kuantitas,
                        'harga_beli' => $barang_from_db->harga_beli,
                        'harga_jual' => $barang_from_db->harga_jual,
                        'pajak' => 0.015,
                        'harga_beli_terpajak' => $barang_from_db->harga_beli * 0.015,
                    ]);
                }

            }
        }

        // Lalu hitung lagi totalnya
        $helper = ExportPenjualanHelper::all();
        foreach($helper as $data){
            $harga_jual = $data->harga_jual;
            $harga_beli = $data->harga_beli;
            $total_barang = 0;

            for($i = 1; $i<=31; $i++){
                $total_barang += $data['d'.$i];
            }

            $harga_beli_terpajak = $harga_beli + $harga_beli * 0.015;
            $total_pokok = $harga_beli_terpajak * $total_barang;
            $total_jual = $harga_jual * $total_barang;

            $laba = $total_jual - $total_pokok;

            // then update
            $data->update([
                'jumlah_barang' => $total_barang,
                'harga_beli_terpajak' => $harga_beli_terpajak,
                'total_pokok' => $total_pokok,
                'total_jual' => $total_jual,
                'laba' => $laba
            ]);
        }
        return Excel::download(new PenjualanExport($start,$end), 'Export-Penjualan-'.date("Y-m-d h:i:s").'.xlsx');

        return "OK";
    }
}
