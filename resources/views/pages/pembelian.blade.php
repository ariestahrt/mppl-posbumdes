@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Pembelian')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
@endsection

@section('header')
{{-- @include('panels.back-header')--}}
@endsection

@section('content')
</div>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3 style="">Pembelian</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-1">
            <div class="mr-auto float-left">
               <input type="text" class="custom-select" name="daterange" id="daterange" value=""/>
            </div>
            <div class="float-right">
               <a href="{{route('devs_get_tambah_pembelian')}}">
                  <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#default">
                     <i class="bx bx-plus"></i>&nbsp;&nbsp;Pembelian Baru
                  </button>
               </a>
               <!-- <button type="button" class="btn btn-primary bg-white round vert-top" id="save-file">
                  <i class="bx bx-download"></i>&nbsp;&nbsp;Simpan Dokumen
               </button> -->
            </div>
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
                              <th>ID</th>
                              <th>PEGAWAI</th>
                              <th>TOTAL BELANJA</th>
                              <th>TANGGAL</th>
                              <th>AKSI</th>
                           </tr>
                        </thead>
                        <tbody>
                           </tbody>
                           <tfoot>
                           <tr>
                              <th>ID</th>
                              <th>PEGAWAI</th>
                              <th>TOTAL BELANJA</th>
                              <th>TANGGAL</th>
                              <th>AKSI</th>
                           </tr>
                        </tfoot>
                     </table>
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
   <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
   <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
   <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
   <script>
      let table;
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();




      /*
      // Update Table
      */
      function getTableData(start, end){

         if(table){
            table.destroy();
         }

         $.ajax({
            url: "/devs/api/pembelian/"+start+"/"+end+"/",
            async: false,
            headers: { 'ITS': 'KKN Desa Tihingan' }
         }).done(function(msg) {
            const result = JSON.parse(msg);
            console.log(result);
            let dataset = [];

            result.forEach(item => {
               console.log(item);
               let temp = [];
               temp.push(item.id);
               temp.push(item.pegawai);
               temp.push(item.total_belanja);
               temp.push(item.tanggal.replace("T", " ").replace(".000000Z", ""));
               let detHtml = `
                  <div class="d-flex justify-content-center">
                     <a href="/devs/pembelian/`+item.id+`" class="mr-1">[Detail]</a>
                  </div>
               `
               temp.push(detHtml);

               dataset.push(temp);
            });

            // CONSTRUCT DATATABLE
            table = $('#datatable').DataTable( {
               data: dataset,
               columns: [
                  { title: "ID", width: "5%" },
                  { title: "PEGAWAI", width: "15%" },
                  { title: "TOTAL BELANJA", width: "20%", render: $.fn.dataTable.render.number('.', ',', 2, '') },
                  { title: "TANGGAL TRANSAKSI", width: "20%" },
                  { title: "AKSI", width: "5%" },
               ],
               order: [[3, "desc"]]
            } );
         });
      }



      /*
      // Document Ready Listener
      */
      $(document).ready(function() {
         $(function() {
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
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                  ],
                  firstDay: 1
               },
               startDate: '01' + '/' + mm + '/' + yyyy,
               endDate: dd + '/' + mm + '/' + yyyy
            }, function(start, end, label) {
               console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
               getTableData(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'));
            });
         });

         setTimeout(function(){
            let rentang_tanggal = $('#daterange').val();
            const tanggal = rentang_tanggal.split(" - ");
            getTableData(tanggal[0].replace(/\//g, '-'), tanggal[1].replace(/\//g, '-'));
         }, 300);
      });
   </script>
   @endsection