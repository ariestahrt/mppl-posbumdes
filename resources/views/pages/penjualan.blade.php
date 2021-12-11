@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Penjualan')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection

@section('header')
{{-- navabar  --}}
<!-- @include('panels.back-header') -->
@endsection

@section('content')
</div>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3>Penjualan</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-1">
            <div class="mr-auto float-left">
               <input type="text" class="custom-select" name="daterange" id="daterange" value=""/>
            </div>
            <div class="float-right">
               <button type="button" class="btn btn-primary bg-white round vert-top" id="save-file" onclick="ajaxDownloadFile()">
                  <i class="bx bx-download"></i>&nbsp;&nbsp;Simpan Dokumen
               </button>
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
                              <th>Pegawai</th>
                              <th>Total Belanja</th>
                              <th>Total Bayar</th>
                              <th>Kembalian</th>
                              <th>Keterangan</th>
                              <th>Tanggal</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>ID</th>
                              <th>Pegawai</th>
                              <th>Total Belanja</th>
                              <th>Total Bayar</th>
                              <th>Kembalian</th>
                              <th>Keterangan</th>
                              <th>Tanggal</th>
                              <th>Aksi</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   {{-- Edit Bon Modal  --}}
   <div class="modal fade text-left" id="bon" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title" id="myModalLabel1">Edit Bon</h3>
               <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                  <i class="bx bx-x"></i>
               </button>
            </div>
            <div class="modal-body">
               <form method="#" action="#">
                  @csrf
                  <div class="form-group">
                     <label for="roundText">ID Transaksi</label>
                     <input id="input-bon-id-transaksi" disabled type="text" class="form-control" name="id-transaksi" placeholder="ID Transaksi" value="" disabled>
                     <span id="invalid-create-feedback-id-transaksi" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <label for="roundText">Total Belanja</label>
                  <div class="form-group input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                     </div>
                     <input id="input-bon-total-belanja" disabled type="text" class="form-control" name="total-belanja" placeholder="Total Belanja" value="">
                     <span id="invalid-create-feedback-total-belanja" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <label for="roundText">Total Terbayar</label>
                  <div class="form-group input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                     </div>
                     <input id="input-bon-total-terbayar" disabled type="text" class="form-control" name="total-terbayar" placeholder="Total Terbayar" value="">
                     <span id="invalid-create-feedback-total-terbayar" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <label for="roundText">Pembayaran</label>
                  <div class="form-group input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                     </div>
                     <input id="input-bon-pembayaran" type="number" class="form-control" name="pembayaran" placeholder="Pembayaran" value="" onchange="calculateChange()">
                     <span id="invalid-create-feedback-pembayaran" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <label for="roundText">Kekurangan</label>
                  <div class="form-group input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                     </div>
                     <input id="input-bon-kekurangan" disabled type="text" class="form-control" name="kekurangan" placeholder="Kekurangan" value="">
                     <span id="invalid-create-feedback-kekurangan" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group" id="keterangan">
                     <label for="roundText">Keterangan</label>
                     <textarea id="input-bon-keterangan" type="text" class="form-control" name="keterangan" placeholder="Keterangan" value=""></textarea>
                     <span id="invalid-create-feedback-keterangan" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="d-flex justify-content-center">
                     <button type="button" class="btn btn-danger d-block round bg-white btn-submit mr-2" data-dismiss="modal" aria-label="Close">Batalkan</button>
                     <button type="button" id="bayar-button" onclick="postBonRequest()" class="btn btn-success d-block round bg-white btn-submit">Bayar</button>
                  </div>
               </form>
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
<script src="{{asset('vendors/js/extensions/numeral/numeral.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
   let table;
   var today = new Date();
   var dd = String(today.getDate()).padStart(2, '0');
   var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
   var yyyy = today.getFullYear();

   let global_start_date = '';
   let global_end_date = '';

   let total_belanja;
   let total_bayar;
   let total_terbayar;
   let updateId;



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
   // Get Table Data based on Start Date and End Date
   */
   function getTableData(start, end){
      // console.log(bulan, tahun)
      if(table){
         table.destroy();
      }

      $.ajax({
         url: "/devs/api/penjualan/"+start+"/"+end+"/",
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
            temp.push(item.total_bayar);
            temp.push(item.kembalian);
            if(item.status_bayar == 1) {
               let keterangan_bon = `<div class="text-success">${item.keterangan.replace(/\n/g, "<br />")}</div>`;
               temp.push(item.keterangan === "-" ? "" : keterangan_bon);
            } else {
               let keterangan_bon = `<div class="text-danger">${item.keterangan.replace(/\n/g, "<br />")}</div>`;
               temp.push(item.keterangan === "-" ? "" : keterangan_bon);
            }
            temp.push(item.tanggal.replace("T", " ").replace(".000000Z", ""));
            let button_html = `
            <div class="d-flex justify-content-center">
            <a data-toggle="modal" data-target="#bon" href="#" onclick="editItem(` + item.id + `)" >[Edit Bon]</a>
            </div>
            `;
            temp.push(item.status_bayar == 1 ? "" : button_html);

            dataset.push(temp);
         });

         // CONSTRUCT DATATABLE
         table = $('#datatable').DataTable( {
            data: dataset,
            columns: [
               { title: "ID", width: "5%" },
               { title: "PEGAWAI", width: "15%" },
               { title: "TOTAL BELANJA", width: "15%", render: $.fn.dataTable.render.number('.', ',', 2, '') },
               { title: "TOTAL BAYAR", width: "15%", render: $.fn.dataTable.render.number('.', ',', 2, '') },
               { title: "KEMBALIAN", width: "10%", render: $.fn.dataTable.render.number('.', ',', 2, '') },
               { title: "KETERANGAN", width: "15%"},
               { title: "TANGGAL TRANSAKSI", width: "15%" },
               { title: "AKSI", width: "10%" }
            ],
            order: [[6, "desc"]]
         } );
      });
   }



   /*
   // Edit Bon Item
   */
   function editItem(id) {
      $.ajax({
         url: "/devs/api/bon_penjualan/" + id,
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         updateId = id;
         const result = JSON.parse(msg);
         console.log(result);

         // CONSTRUCT DATATABLE
         $("#input-bon-pembayaran").val("");
         $("#input-bon-id-transaksi").val(result.id);
         total_belanja = Number(result.total_belanja);
         $("#input-bon-total-belanja").val(numeral(result.total_belanja).format('0.0[,]00'));
         total_bayar = Number(result.total_bayar);
         $("#input-bon-total-terbayar").val(numeral(result.total_bayar).format('0.0[,]00'));
         $("#input-bon-kekurangan").val(numeral(result.kembalian).format('0.0[,]00'));
         $("#input-bon-keterangan").val(result.keterangan);
      });
   }



   /*
   // Change Input Field
   */
   function calculateChange() {
      $("#input-bon-total-terbayar").val(numeral(total_bayar + Number($("#input-bon-pembayaran").val())).format('0.0[,]00'));
      $("#input-bon-kekurangan").val(numeral(total_bayar + Number($("#input-bon-pembayaran").val()) - total_belanja).format('0.0[,]00'));
      console.log(total_bayar + Number($("#input-bon-pembayaran").val() - total_belanja))
      total_terbayar = Number(total_bayar + $("#input-bon-pembayaran").val());
   }



   /*
   // Send Post Request to update Penjualan Data
   */
   function postBonRequest() {
      $.ajax({
         url: "/devs/api/bon_penjualan/update",
         method : 'POST',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data : {
            '_token' : '{{ csrf_token() }}',
            "id" : updateId,
            "pembayaran" : Number($("#input-bon-pembayaran").val()),
            "keterangan" : String($("#input-bon-keterangan").val())
         }
      }).done(function(msg) {
         let result = JSON.parse(msg);
         if(result.error > 0) {
            $('#bon').modal('hide');
            Swal.fire(
               'ERROR!',
               result.message,
               'error'
            );
         } else {
            $('#bon').modal('hide');
            getTableData(global_start_date, global_end_date)
            Swal.fire(
               'SUCCESS!',
               result.message,
               'success'
            );
         }
      });
      // console.log(data)
   }

   /*
   // On Document Ready Listener
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
            global_start_date = start.format('DD-MM-YYYY');
            global_end_date = end.format('DD-MM-YYYY');
            
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
            getTableData(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'));
         });
      });

      setTimeout(function(){
         let rentang_tanggal = $('#daterange').val();
         const tanggal = rentang_tanggal.split(" - ");

         global_start_date = tanggal[0].replace(/\//g, '-');
         global_end_date = tanggal[1].replace(/\//g, '-');

         getTableData(tanggal[0].replace(/\//g, '-'), tanggal[1].replace(/\//g, '-'));
      }, 300);
   });

   function ajaxDownloadFile(){
      // Check apakah data yang diminta berada pada bulan yang sama apa engga?
      // Hardcode aja
      bulan_start = global_start_date.split('-')[1];
      bulan_end = global_end_date.split('-')[1];

      if(bulan_start != bulan_end){
         toastr['error']('Export penjualan hanya bisa pada bulan yang sama!', 'ERROR!', { positionClass: "toast-top-center" });
         return;
      }

      $.ajax({
         url: '/devs/export/penjualan/'+global_start_date+'/'+global_end_date,
         type: 'GET',
         success: function() {
            window.location = '/devs/export/penjualan/'+global_start_date+'/'+global_end_date;
         }
      });
   }

</script>
   @endsection