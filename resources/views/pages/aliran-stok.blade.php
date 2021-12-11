@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Aliran Stok')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection

@section('header')
{{-- navabar --}}
{{-- @include('panels.back-header') --}}
@endsection

@section('content')
</div>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3>Aliran Stok</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-1">
            <div class="mr-auto float-left">
               <input type="text" class="custom-select" name="daterange" id="daterange" value=""/>
            </div>
            <!-- <div class="float-right">               
              <button type="button" class="btn btn-primary bg-white round vert-top" id="save-file" onclick="ajaxDownloadFile()">
                <i class="bx bx-download"></i>&nbsp;&nbsp;Simpan Dokumen
              </button>
            </div> -->
         </div>
         
         <hr class="my-0">

         <!-- table bordered -->
         <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
               <div class="row">
                  <div class="col-12">
                     <table class="table zero-configuration" id="datatable">
                        <thead>
                           <tr>
                              <th>ID Tr</th>
                              <th>Nama</th>
                              <th>Satuan</th>
                              <th>Jumlah</th>
                              <th>Harga</th>
                              <th>Total Harga</th>
                              <th>Tgl. Dicatat</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>ID Tr</th>
                              <th>Nama</th>
                              <th>Satuan</th>
                              <th>Jumlah</th>
                              <th>Harga</th>
                              <th>Total Harga</th>
                              <th>Tgl. Dicatat</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!--/ CSS Classes -->

@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/numeral/numeral.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script>
   let table;
   let transData = [];
   var today = new Date();
   var dd = String(today.getDate()).padStart(2, '0');
   var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
   var yyyy = today.getFullYear();



   /* 
   // Numeral formatting
   */
   numeral.register('locale', 'id', {
      delimiters: {
         thousands: '.',
         decimal: ','
      },
      abbreviations: {
         thousand: 'rb',
         million: 'jt',
         billion: 'm',
         trillion: 't'
      },
      currency: {
         symbol: 'Rp.'
      }
   });
   numeral.locale('id');


   
   /* 
   // Datepicker call func
   */
   let datepicker = function() {
      $('input[name="daterange"]').daterangepicker({
         opens: 'left',
         applyButtonClasses: 'btn-primary-invert',
         locale: {
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Cari",
            cancelLabel: "Batalkan",
            fromLabel: "Dari",
            toLabel: "Sampai",
            customRangeLabel: "Custom",
            weekLabel: "W",
            daysOfWeek: [
                  "Min",
                  "Sen",
                  "Sel",
                  "Rab",
                  "Kam",
                  "Jum",
                  "Sab"
            ],
            monthName: [
                  "January","February","March","April","May","June","July","August","September","October","November","December"
            ],
            firstDay: 1
         },
         startDate: '01' + '/' + mm + '/' + yyyy,
         endDate: dd + '/' + mm + '/' + yyyy
      }, function(start, end, label) {
         console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
         getTableData(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'));
      });
   };



   /*
   // On Document Loaded
   */
   $(document).ready(function() {
      datepicker();
      
      if(table){
         table.destroy();
      }

      setTimeout(function(){
         let rentang_tanggal = $('#daterange').val();
         const tanggal = rentang_tanggal.split(" - ");
         getTableData(tanggal[0].replace(/\//g, '-'), tanggal[1].replace(/\//g, '-'));
      }, 300);
   });



   /* 
   // Update DataTables after Data Update
   */
   function getTableData(start, end) {
      if(table){
         table.destroy();
      }

      $.ajax({
         url: "/devs/api/aliran_stok/"+start+"/"+end+"/",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         transData = [];
         const result = JSON.parse(msg);
         console.log(result);

         result.forEach((item, index) => {
            console.log(item);
            let temp = [];

            temp.push(item.tipe + "/" + item.id);
            temp.push(item.nama_barang);
            temp.push(item.satuan);
            temp.push(item.kuantitas);
            temp.push(item.harga);
            temp.push(item.total_belanja);
            temp.push(item.tanggal.replace("T", " ").replace(".000000Z", ""));
            temp.push(item.id);

            transData.push(temp);
         });

         // CONSTRUCT DATATABLE
         table = $('#datatable').DataTable( {
            data: transData,
            columns: [
               { title: "ID Tr", width: "10%" },
               { title: "NAMA", width: "15%" },
               { title: "SATUAN", width: "10%" },
               { title: "JUMLAH", width: "10%" },
               { title: "HARGA", width: "15%", render: $.fn.dataTable.render.number('.', ',', 0, '') },
               { title: "TOTAL HARGA", width: "15%", render: $.fn.dataTable.render.number('.', ',', 0, '') },
               { title: "TANGGAL", width: "15%" },
            ],
            order: [[ 6, "desc" ]]
         } );
      });
   }



   /* 
   // Barcode Scanning Listener
   */
   let code = "";
   document.addEventListener('keydown', e=>{
      let reading = false;
      if (e.keyCode === 13){
         if($('#default').is(':visible')) {
            e.preventDefault();
            $('#input-create-kode').val(code);
            $('#input-create-nama').focus();
         } else {
            table.search( code ).draw();
         }

         code = "";
      }else{
         code += e.key;
      }
      //Timeout 200ms after the first read and clear everything
      if(!reading){
         reading = true;
         setTimeout(()=>{
            console.log('[NaB]')
            code = "";
            reading = false;
         }, 200);
      }
   });
</script>
@endsection
