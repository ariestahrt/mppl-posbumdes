<?php

namespace App\Exports;

use App\Models\Penjualan;
use App\Models\ExportHelper;
use App\Models\ExportPenjualanHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill as StyleFill;

class PenjualanExport implements FromArray, WithProperties, WithEvents
{
    // Export hanya bisa dilakukan pada bulan yang sama
    public string $startDate = '';
    public string $endDate = '';
    // public static $cell_name = [
    //     'A', 'B', 'C', 'D', 'E', 'F',
    //     'G', 'H', 'I', 'J', 'K', 'L',
    //     'M', 'N', 'O', 'P', 'Q', 'R',
    //     'S', 'T', 'U', 'V', 'W', 'X',
    //     'Y', 'Z',
    //     'AA', 'AB', 'AC', 'AD', 'AE', 'AF',
    //     'AG', 'AH', 'AI', 'AJ', 'AK', 'AL',
    //     'AM', 'AN', 'AO', 'AP', 'AQ', 'AR',
    //     'AS', 'AT', 'AU', 'AV', 'AW', 'AX',
    //     'AY', 'AZ',
    //     'BA', 'BB', 'BC', 'BD', 'BE', 'BF',
    //     'BG', 'BH', 'BI', 'BJ', 'BK', 'BL',
    //     'BM', 'BN', 'BO', 'BP', 'BQ', 'BR',
    //     'BS', 'BT', 'BU', 'BV', 'BW', 'BX',
    //     'BY', 'BZ',
    // ];

    public function __construct($start, $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;
        ExportHelper::create([
            'start_date' => $start,
            'end_date' => $end
        ]);
    }

    public function properties(): array
    {
        return [
            'creator'        => 'TIM ICT KKN Desa Tihingan',
            'lastModifiedBy' => 'TIM ICT KKN Desa Tihingan',
            'title'          => 'Export Stok',
            'description'    => 'Export Stok',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => '',
        ];
    }

    public function array(): array
    {
        // hitung total hari yang diminta
        $carbon_startDate = Carbon::createFromFormat('d-m-Y H:i', $this->startDate." 00:00");
        $carbon_endDate = Carbon::createFromFormat('d-m-Y H:i', $this->endDate." 23:59");
        
        $int_startDate = intval($carbon_startDate->format('d'));
        $int_endDate = intval($carbon_endDate->format('d'));

        $result = [];
        // REKAPAN PENJUALAN																																									
        // BUMDES BUKTI SEDANA ARTHA (BISA)																																									
        // KECAMATAN BANJARANGKAN																																									
        // KABUPATEN KLUNGKUNG																																									
        
        array_push($result,
            ["", "", "REKAPAN PENJUALAN"],
            ["", "", "BUMDES BUKTI SEDANA ARTHA (BISA)"],
            ["", "", "KECAMATAN BANJARANGKAN"],
            ["", "", "KABUPATEN KLUNGKUNG"],
            ["", "", ""],
            ["PERIODE", "$this->startDate s/d $this->endDate"],
            [""],
        );

        $heading1 = ["NAMA BARANG", "SATUAN", "TANGGAL"];
        for($i = $int_startDate; $i<$int_endDate; $i++){
            array_push($heading1, "");
        }
        $heading1 = array_merge($heading1, ["JUMLAH BARANG TERJUAL", "HARGA POKOK", "PAJAK 1,5 %", "HARGA POKOK + PAJAK", "HARGA JUAL",	"TOTAL POKOK", "TOTAL JUAL", "LABA"]);
        array_push($result, $heading1);
        
        $heading2 = ["", ""];
        for($i = $int_startDate; $i<=$int_endDate; $i++){
            array_push($heading2, "$i");
        }
        $heading2 = array_merge($heading2, ["", "", "", "", "",	"", "", ""]);
        array_push($result, $heading2);

        $total_pokok = 0;
        $total_jual = 0;
        $total_laba = 0;

        // Get data from helper
        $data_helper = ExportPenjualanHelper::all();
        foreach($data_helper as $data){
            $current_row = [$data->nama_barang, $data->satuan];

            $tanggal_terpush = [];
            for($i = $int_startDate; $i<=$int_endDate; $i++){
                array_push($tanggal_terpush, $data['d'.$i]);
            }

            $current_row = array_merge($current_row, $tanggal_terpush);
            $current_row = array_merge($current_row, [
                $data->jumlah_barang,
                $data->harga_beli,
                $data->pajak,
                $data->harga_beli_terpajak,
                $data->harga_jual,
                $data->total_pokok,
                $data->total_jual,
                $data->laba
            ]);

            $total_pokok += $data->total_pokok;
            $total_jual += $data->total_jual;
            $total_laba += $data->laba;

            array_push($result, $current_row);
        }

        $current_row = ["", ""];
        for($i = $int_startDate; $i<=$int_endDate + 5; $i++){
            array_push($current_row, "");
        }
        
        $current_row = array_merge($current_row, [$total_pokok, $total_jual, $total_laba]);

        array_push($result, $current_row);

        // then push totalnya


        // Set Heading
        // array_push($result, [
        //     "kode_barang", "nama_barang", "satuan", "harga_beli", "harga_jual", "stok", "status", "Tanggal dibuat", "Terakhir diedit"
        // ]);

        // $all_stok = Stok::all();
        // foreach ($all_stok as $stok) {

        //     array_push($result, [
        //         $stok->kode_barang,
        //         $stok->nama_barang,
        //         $stok->satuan,
        //         strval($stok->harga_beli),
        //         strval($stok->harga_jual),
        //         strval($stok->stok),
        //         strval($stok->status),
        //         $stok->created_at,
        //         $stok->updated_at
        //     ]);
        // }

        // return [
        //     $result
        // ];
        return $result;
    }

    use Exportable, RegistersEventListeners;
    
    public static function beforeExport(BeforeExport $event)
    {
        //
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        //
    }

    public static function afterSheet(AfterSheet $event)
    {
        $cell_name = [
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X',
            'Y', 'Z',
            'AA', 'AB', 'AC', 'AD', 'AE', 'AF',
            'AG', 'AH', 'AI', 'AJ', 'AK', 'AL',
            'AM', 'AN', 'AO', 'AP', 'AQ', 'AR',
            'AS', 'AT', 'AU', 'AV', 'AW', 'AX',
            'AY', 'AZ',
            'BA', 'BB', 'BC', 'BD', 'BE', 'BF',
            'BG', 'BH', 'BI', 'BJ', 'BK', 'BL',
            'BM', 'BN', 'BO', 'BP', 'BQ', 'BR',
            'BS', 'BT', 'BU', 'BV', 'BW', 'BX',
            'BY', 'BZ',
        ];

        // Set default font
        $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');

        $event->sheet->getDelegate()->mergeCells('A8:A9'); // CELL "NAMA BARANG"
        $event->sheet->getDelegate()->mergeCells('B8:B9'); // CELL "STATUS"
        
        // SET ALIGNMENT HEADERNYA
        $event->sheet->getStyle('A8:AO9')->getAlignment()->applyFromArray(
            array('horizontal' => 'center', 'vertical' => 'center')
        );

        // SET FONTNYA BOLD
        $event->sheet->getStyle('A1:AO9')->applyFromArray([
            'font' => [
                'bold' => true
            ],
        ]);




        // Resize cell column

        // Resize tanggalnya
        // hitung total hari yang diminta
        $export_helper = ExportHelper::orderBy('id', 'DESC')->first();
        $carbon_startDate = Carbon::createFromFormat('d-m-Y H:i', $export_helper->start_date." 00:00");
        $carbon_endDate = Carbon::createFromFormat('d-m-Y H:i', $export_helper->end_date." 23:59");
        
        $int_startDate = intval($carbon_startDate->format('d'));
        $int_endDate = intval($carbon_endDate->format('d'));

        $cellBoundary = [];
        $cellBoundary["left"] = 0;
        $cellBoundary["right"] = 2 + $int_endDate - $int_startDate + 8;
        
        // Warnai headernya
        $event->sheet->getStyle('A8:'.$cell_name[$cellBoundary["right"]].'9')->getFill()
            ->setFillType(StyleFill::FILL_SOLID)->getStartColor()->setARGB('EBF1DE');
        
        // Merge TITLE
        $event->sheet->getDelegate()->mergeCells('C1:'.$cell_name[$cellBoundary["right"]].'1');
        $event->sheet->getDelegate()->mergeCells('C2:'.$cell_name[$cellBoundary["right"]].'2');
        $event->sheet->getDelegate()->mergeCells('C3:'.$cell_name[$cellBoundary["right"]].'3');
        $event->sheet->getDelegate()->mergeCells('C4:'.$cell_name[$cellBoundary["right"]].'4');

        // Set tinggi salah satu headernya
        $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(35);

        // SET ALIGNMENT TITLENYA
        $event->sheet->getStyle('C1:'.$cell_name[$cellBoundary["right"]].'4')->getAlignment()->applyFromArray(
            array('horizontal' => 'center', 'vertical' => 'center')
        );
        
        for($i = 0; $i<=$int_endDate - $int_startDate; $i++){
            $event->sheet->getDelegate()->getColumnDimension($cell_name[$i+2])->setWidth(3.5);
        }

        // MERGE "TANGGAL"
        $event->sheet->getDelegate()->mergeCells('C8:'.$cell_name[$int_endDate - $int_startDate + 2].'8');

        // MERGE SISANYA
        for($i = 1; $i<=8; $i++){
            $event->sheet->getDelegate()->mergeCells($cell_name[$int_endDate - $int_startDate + 2 + $i].'8:'.$cell_name[$int_endDate - $int_startDate + 2 + $i].'9');
        }

        // SET LEBAR KOLOMNYA
        $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 3])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 4])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 5])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 6])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 7])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 8])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 9])->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension($cell_name[$int_endDate - $int_startDate + 10])->setWidth(15);
        
        $event->sheet->getStyle($cell_name[$int_endDate - $int_startDate + 3].'8:'.$cell_name[$int_endDate - $int_startDate + 10].'9')->getAlignment()->setWrapText(true);

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        
        // Set bordernya setiap cell
        for($i = 8; $i <= ExportPenjualanHelper::count()+10; $i++){
            for($j = 0; $j <= $cellBoundary["right"]; $j++){
                $event->sheet->getStyle($cell_name[$j].strval($i))->applyFromArray($styleArray);
            }
        }

        // Warnain hitem footenya
        $event->sheet->getStyle('A'.strval(ExportPenjualanHelper::count()+10).':'.$cell_name[$cellBoundary["right"]].strval(ExportPenjualanHelper::count()+10))->getFill()
            ->setFillType(StyleFill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        
    }

}
