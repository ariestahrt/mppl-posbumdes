<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;

use Illuminate\Http\Request;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function api_get_data_penjualan($start, $end) {
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 23:59");
        
        $penjualan = Penjualan::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = array();

        foreach ($penjualan as $item) {
            $name = $item->created_at->format('d M');
            if(array_key_exists($name, $data)) {
                $data[$name] += (int)($item->total_belanja);
            } else {
                $data[$name] = (int)($item->total_belanja);
            }
        }

        return json_encode([
            "error" => 0,
            "data" => $data
        ]);
    }



    public function api_get_data_pembelian($start, $end) {
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $start." 00:00");
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $end." 23:59");
        
        $pembelian = Pembelian::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = array();

        foreach ($pembelian as $item) {
            $name = $item->created_at->format('d M');
            if(array_key_exists($name, $data)) {
                $data[$name] += (int)($item->total_belanja);
            } else {
                $data[$name] = (int)($item->total_belanja);
            }
        }

        return json_encode([
            "error" => 0,
            "data" => $data
        ]);
    }
}
