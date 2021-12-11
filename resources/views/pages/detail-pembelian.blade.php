@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Pembelian')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
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
            <h3>Detail Pembelian</h3>
            @include("panels.back-button")
            <input id="id-transaksi" hidden type="" value={{ $id }}>
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
                              <th>NAMA BARANG</th>
                              <th>SATUAN</th>
                              <th>JUMLAH</th>
                              <th>HARGA BELI</th>
                              <th>HARGA TOTAL</th>
                              <th>TANGGAL</th>
                              <th>AKSI</th>
                           </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>ID</th>
                              <th>NAMA BARANG</th>
                              <th>SATUAN</th>
                              <th>JUMLAH</th>
                              <th>HARGA BELI</th>
                              <th>HARGA TOTAL</th>
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


   
   {{-- Edit Barang Modal  --}}
   <div class="modal fade text-left" id="modal-edit" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title" id="myModalLabel1">Edit Data Pembelian Barang</h3>
               <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                  <i class="bx bx-x"></i>
               </button>
            </div>
            <div class="modal-body">
               <form method="#" action="#">
                  @csrf
                  <div class="form-group">
                     <label for="roundText">ID Transaksi Pembelian</label>
                     <input id="input-edit-id-tr" disabled type="text" class="form-control" name="id-tr" placeholder="id-tr Barang" value="">
                     <span id="invalid-edit-feedback-id-tr" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group">
                     <label for="roundText">Nama Barang</label>
                     <input id="input-edit-nama" disabled type="text" class="form-control" name="nama" placeholder="Nama Barang" value="">
                     <span id="invalid-edit-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group">
                     <label for="roundText">Satuan</label>
                     <input id="input-edit-satuan" disabled type="text" class="form-control" name="satuan" placeholder="Satuan" value="">
                     <span id="invalid-edit-feedback-satuan" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group">
                     <label for="roundText">Jumlah</label>
                     <div class="d-flex">
                        <input id="input-edit-jumlah" disabled type="text" class="form-control" name="jumlah" placeholder="Jumlah" onchange="updateTotal()" value="">
                        <a href="#" onclick="toggleForm('#input-edit-jumlah')" class="ml-1"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                     </div>
                     <span id="invalid-edit-feedback-jumlah" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group">
                     <label for="roundText">Harga Beli</label>
                     <div class="d-flex">
                        <input id="input-edit-harga-beli" onclick="resetInput('#input-edit-harga-beli')"  disabled type="text" class="form-control" name="harga-beli" placeholder="Harga Beli" onchange="updateTotal()" value="">
                        <a href="#" onclick="toggleForm('#input-edit-harga-beli')" class="ml-1"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                     </div>
                     <span id="invalid-edit-feedback-harga-beli" class="invalid-feedback" style="display: none;"></span>
                  </div>
                  <div class="form-group">
                     <label for="roundText">Total Harga</label>
                     <input id="input-edit-total-harga" disabled type="text" class="form-control" name="total-harga" placeholder="Total Harga" value="">
                     <span id="invalid-edit-feedback-total-harga" class="invalid-feedback" style="display: none;"></span>
                  </div>
               </form>
               <button type="button" onclick="sendUpdateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Simpan</button>
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
      let dataset = [];
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();
      
      let detailPembelian = {!!json_encode($detailPembelian -> toArray()) !!}


      /*
      // Toggle Disabled Form
      */
      function toggleForm(element){
         if($(element).attr('disabled') == "disabled") {
            $(element).prop( "disabled", false );
         } else {
            $(element).prop( "disabled", true );
         }
      }

      /* 
      // Open Edit Modal for Each Item
      */
      function openEditModal(index){
         $('#input-edit-id-tr').val(dataset[index][0]);
         $('#input-edit-nama').val(dataset[index][1]);
         $('#input-edit-satuan').val(dataset[index][2]);
         $('#input-edit-jumlah').val(dataset[index][3]);
         $('#input-edit-harga-beli').val(numeral(dataset[index][4]).format('0.[,]00'));
         $('#input-edit-total-harga').val(numeral(dataset[index][5]).format('0.[,]00'));
      };
      
      /* 
      // Reset Input On Click
      */
      function resetInput(htmlId){
         $(htmlId).val('');
      }

      /*
      // Update Total Price on Edit Modal
      */
      function updateTotal() {
         let jumlah = $('#input-edit-jumlah').val();
         let harga = String($('#input-edit-harga-beli').val()).replace(/\./g, "").replace(/,/g, "");

         $('#input-edit-total-harga').val(numeral(jumlah * harga).format('0.[,]00'));
         $('#input-edit-total-harga').addClass('disabledisabled text-warning');
      }


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
      // Send update request to pembelian controller
      */
      function sendUpdateRequest() {
         let idTransaksi = $('#input-edit-id-tr').val();
         let jumlah = $('#input-edit-jumlah').val().replace(/\./g, "").replace(/,/g, "")
         let harga = $('#input-edit-harga-beli').val().replace(/\./g, "").replace(/,/g, "")
         $.ajax({
            url: "/devs/api/pembelian/" + idTransaksi,
            method: 'PUT',
            async: true,
            headers: { 'ITS': 'KKN Desa Tihingan' },
            data : {
               '_token': '{{ csrf_token() }}',
               'jumlah': jumlah,
               'harga': harga,
            }
         }).done(function(msg) {
            // Loading Screen End
            // Success Toastr
            console.log(msg);
            let result = JSON.parse(msg);
            if(result.error == 0){
               toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
            }else{
               toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
            }

            ['id-tr', 'nama', 'jumlah', 'satuan', 'harga-beli', 'harga-total'].forEach(item =>{
               $('#input-edit-'+item).val("");
            });

            getTableData();
            $('#modal-edit').modal('hide');
         }).fail(function(xhr, status, error) {
            let res = JSON.parse(xhr.responseText);
            Object.entries(res.errors).forEach((entry) => {
               const [key, value] = entry;
               console.log(`${key}: ${value}`);
               $('#input-edit-'+key).addClass("is-invalid");
               $('#invalid-edit-feedback-'+key).html(value);
               $('#invalid-edit-feedback-'+key).show();
            });
            toastr['error']('Terdapat Kesalahan Dalam Input Data Barang', 'ERROR!', { positionClass: "toast-top-center" });
         });
      }

      function getTableData(){
         let id = $('#id-transaksi').val();
         if(table){
            table.destroy();
         }
         console.log("Get Table Data Called");

         $.ajax({
            url: "/devs/api/det_pembelian/"+id,
            async: true,
            headers: { 'ITS': 'KKN Desa Tihingan' }
         }).done(function(msg) {
            const result = JSON.parse(msg);
            console.log(result);
            dataset = []

            result.forEach((item, index) => {
               console.log(item);
               let temp = [];
               temp.push(item.id);
               temp.push(item.nama_barang);
               temp.push(item.satuan);
               temp.push(item.kuantitas);
               temp.push(item.harga_beli);
               temp.push(item.harga_total);
               temp.push(item.tanggal.replace("T", " ").replace(".000000Z", ""));
               let detHtml = `
                  <div class="d-flex justify-content-center">
                     <a onclick='openEditModal(`+ index +`)' class="mr-1" data-toggle="modal" data-target="#modal-edit">[Detail]</a>
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
                  { title: "NAMA BARANG", width: "10%" },
                  { title: "SATUAN", width: "10%" },
                  { title: "JUMLAH", width: "10%" },
                  { title: "HARGA BELI", width: "20%", render: $.fn.dataTable.render.number('.', ',', 0, '') },
                  { title: "HARGA TOTAL", width: "20%", render: $.fn.dataTable.render.number('.', ',', 0, '') },
                  { title: "TANGGAL", width: "20%" },
                  { title: "AKSI", width: "5%" },
               ],
               order: [[6, "desc"]]
            } );
         });
      }

      $(document).ready(function() {
         console.log("Hey from console")
         if(table){
            table.destroy();
         }

         getTableData();
      });
   </script>
   @endsection