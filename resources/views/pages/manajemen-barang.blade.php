@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Manajemen Barang')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection

@section('header')
{{-- navabar --}}
{{-- @include('panels.back-header') --}}
@endsection

@section('content')
</div>
<style>
   .modal-dialog {
      max-width: calc(100vw/2);
      margin: 1.75rem auto;
   }
</style>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3 style="">Manajemen Barang</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-2">
            <div class="mr-auto float-left">
            </div>
            <div class="float-right"> 
            <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#import-stok-modal">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Import Stok
            </button>

               {{-- Import Stok Modal  --}}
               <div class="modal fade text-left" id="import-stok-modal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Import Stok</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form id="import-stok-form" method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Pilih file</label>
                                 <input id="input-file" type="file" class="form-control" name="file" placeholder="Pilih file" value="">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <button type="button" id="import-stok-button" onclick="ajaxUploadFile()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Import</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#default">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Tambah Barang
               </button>

               {{-- Tambah Barang Modal  --}}
               <div class="modal fade text-left" id="default" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Tambah Barang</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Kode Barang</label>
                                 <input id="input-create-kode" type="text" class="form-control" name="kode" placeholder="Kode Barang" value="">
                                 <span id="invalid-create-feedback-kode" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Nama Barang</label>
                                 <input id="input-create-nama" type="text" class="form-control" name="nama" placeholder="Nama Barang" value="">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Satuan</label>
                                 <input id="input-create-satuan" type="text" class="form-control" name="satuan" placeholder="Satuan" value="">
                                 <span id="invalid-create-feedback-satuan" class="invalid-feedback" style="display: none;"></span>
                              </div>                              
                              <div class="form-group">
                                 <label for="roundText">Harga Beli</label>
                                 <input id="input-create-hargabeli" type="text" class="form-control" name="hargabeli" placeholder="Harga Beli" value="">
                                 <span id="invalid-create-feedback-hargabeli" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Harga Jual</label>
                                 <input id="input-create-hargajual" type="text" class="form-control" name="hargajual" placeholder="Harga Jual" value="">
                                 <span id="invalid-create-feedback-hargajual" class="invalid-feedback" style="display: none;"></span>
                              </div>
                           </form>
                           <button type="button" id="create-barang-button" onclick="sendCreateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto d-block">Tambahkan</button>
                        </div>
                     </div>
                  </div>
               </div>
               
               <button type="button" class="btn btn-primary bg-white round vert-top" id="save-file" onclick="ajaxDownloadFile()">
                  <i class="bx bx-download"></i>&nbsp;&nbsp;Simpan Dokumen
               </button>
            </div>
         </div>
         
         <hr class="my-0">

         {{-- Edit Barang Modal  --}}
         <div class="modal fade text-left" id="modal-edit" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="myModalLabel1">Edit Data Barang</h3>
                     <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form method="#" action="#">
                        @csrf
                        <div class="form-group">
                           <label for="roundText">Kode Barang</label>
                           <div class="d-flex">
                              <input id="input-edit-kode" disabled type="text" class="form-control" name="kode" placeholder="Kode Barang" value="">
                              <a href="#" onclick="toggleForm('#input-edit-kode')" class="ml-1"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                           </div>
                           <span id="invalid-edit-feedback-kode" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Nama Barang</label>
                           <input id="input-edit-nama" type="text" class="form-control" name="nama" placeholder="Nama Barang" value="">
                           <span id="invalid-edit-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Stok</label>
                           <div class="d-flex">
                              <input id="input-edit-stok" disabled type="text" class="form-control" name="stok" placeholder="Stok" value="">
                              <a href="#" onclick="toggleForm('#input-edit-stok')" class="ml-1"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                           </div>
                           <span id="invalid-edit-feedback-stok" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Satuan</label>
                           <input id="input-edit-satuan" type="text" class="form-control" name="satuan" placeholder="Satuan" value="">
                           <span id="invalid-edit-feedback-satuan" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Harga Beli</label>
                           <input id="input-edit-hargabeli" disabled type="text" class="form-control" name="hargabeli" placeholder="Harga Beli" value="">
                           <span id="invalid-edit-feedback-hargabeli" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Harga Jual</label>
                           <input id="input-edit-hargajual" disabled type="text" class="form-control" name="hargajual" placeholder="Harga Jual" value="">
                           <span id="invalid-edit-feedback-hargajual" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <p class=""><strong>Catatan</strong>: Untuk memastikan laporan keuangan tetap relevan, <strong>Harga Beli</strong> dan <strong>Harga Jual</strong> tidak dapat dirubah tanpa menambah barang baru.<br />Pertama tambahkan barang baru dengan informasi yang sama dengan data barang lama namun dengan harga beli dan jual baru. Klik tombol edit (pulpen) kemudian edit stok sesuai data lama. Kemudian hapus data lama.</p>
                     </form>
                     <button type="button" onclick="sendUpdateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Simpan</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- table bordered -->
         <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
               <div class="row">
                  <div class="col-12">
                     <table class="table zero-configuration" id="datatable">
                        <thead>
                           <tr>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Stok</th>
                              <th>Satuan</th>
                              <th>Harga Beli</th>
                              <th>Harga Jual</th>
                              <th>Tgl. Dicatat</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($barang as $item)
                              <tr>
                                 <td>{{$item->kode_barang}}</td>
                                 <td>{{$item->nama_barang}}</td>
                                 <td>{{$item->stok}}</td>
                                 <td>{{$item->satuan}}</td>
                                 <td>{{$item->harga_beli}}</td>
                                 <td>{{$item->harga_jual}}</td>
                                 <td>{{$item->created_at}}</td>
                                 <td>
                                    <div class="d-flex justify-content-center">
                                       <a href="#" onclick="openEditModal({{ $item->id }})" class="mr-1" data-toggle="modal" data-target="#modal-edit"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                                       <a href="#" onclick="sendDeleteRequest({{ $item->id }})" ><i class="badge-circle badge-circle-danger bx bx-trash-alt font-medium-1"></i></a>
                                    </div>
                                 </td>
                                 
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Stok</th>
                              <th>Satuan</th>
                              <th>Harga Beli</th>
                              <th>Harga Jual</th>
                              <th>Tgl. Dicatat</th>
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
</div>

<!--/ CSS Classes -->

@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/scripts/modal/components-modal.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/numeral/numeral.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
   let barang_id;
   let table;

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

   // Open Edit Modal for Each Item
   function openEditModal(id){
      $.ajax({
         url: "/devs/api/barang/" + id,
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         barang_id = result.id;
         $('#input-edit-kode').val(result.kode_barang);
         $('#input-edit-nama').val(result.nama_barang);
         $('#input-edit-stok').val(result.stok);
         $('#input-edit-satuan').val(result.satuan);
         $('#input-edit-hargabeli').val(numeral(result.harga_beli).format('0.0[,]00'));
         $('#input-edit-hargajual').val(numeral(result.harga_jual).format('0.0[,]00'));
      });
   };

   // Add stok
   function sendCreateRequest(){
      ['kode', 'nama', 'stok', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
         $('#input-create-'+item).removeClass("is-invalid");
         $('#invalid-create-feedback-'+item).html("");
         $('#invalid-create-feedback-'+item).hide();
      });

      $.ajax({
         url: "/devs/api/barang/create",
         type: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data: {
            '_token': '{{ csrf_token() }}',
            'kode_barang': $('#input-create-kode').val(),
            'nama_barang': $('#input-create-nama').val(),
            'satuan': $('#input-create-satuan').val(),
            'harga_beli': $('#input-create-hargabeli').val(),
            'harga_jual': $('#input-create-hargajual').val(),
         },
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
         ['kode', 'nama', 'stok', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
            $('#input-create-'+item).val("");
         });
         getTableData();
         $('#default').modal('hide');
      }).fail(function(xhr, status, error) {
         // Form Validation Error
         let res = JSON.parse(xhr.responseText);
         Object.entries(res.errors).forEach((entry) => {
            const [key, value] = entry;
            console.log(`${key}: ${value}`);
            $('#input-create-'+key).addClass("is-invalid");
            $('#invalid-create-feedback-'+key).html(value);
            $('#invalid-create-feedback-'+key).show();
         });
         toastr['error']('Terdapat Kesalahan Dalam Input Data Barang', 'ERROR!', { positionClass: "toast-top-center" });
      });
   }

   // Send the Update Request After Editing Stok Barang Information
   function sendUpdateRequest(){
      ['kode', 'nama', 'stok', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
         $('#input-edit-'+item).removeClass("is-invalid");
         $('#invalid-edit-feedback-'+item).html("");
         $('#invalid-edit-feedback-'+item).hide();
      });

      // Loading screen start
      $.blockUI({
         message: '<div class="bx bx-loader-alt icon-spin" style="font-size: 5rem;"></div>',
         timeout: 1000,
         overlayCSS: {
            backgroundColor: '#000000',
            opacity: 0.35,
            cursor: 'wait'
         },
         css: {
            color: '#fff',
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
         }
      });
      
      $.ajax({
         url: "/devs/api/barang/" + barang_id,
         method: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data : {
            '_token': '{{ csrf_token() }}',
            'kode_barang': $('#input-edit-kode').val(),
            'nama_barang': $('#input-edit-nama').val(),
            'stok': $('#input-edit-stok').val(),
            'satuan': $('#input-edit-satuan').val(),
            'harga_beli': $('#input-edit-hargabeli').val(),
            'harga_jual': $('#input-edit-hargajual').val(),
         }
      }).done(function(msg) {
         // Loading Screen End
         // Success Toastr
         let result = JSON.parse(msg);
         if(result.error == 0){
            toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
         }else{
            toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
         }

         ['kode', 'nama', 'stok', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
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

   // Delete stok
   function sendDeleteRequest(id){
      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-danger mr-1',
            cancelButton: 'btn btn-warning'
         },
         buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
         title: 'Hapus Barang?',
         text: "Anda tidak akan bisa mengembalikan data ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Hapus!',
         cancelButtonText: 'Batalkan'
      }).then((result) => {
         if (result.isConfirmed) {
         $.ajax({
            url: "/devs/api/barang/" + id,
            type: 'DELETE',
            async: true,
            headers: { 'ITS': 'KKN Desa Tihingan' },
            data: {
               "_token": '{{ csrf_token() }}',
            },
         }).done(function(msg) {
            // Loading Screen End
            // Success Toastr
            let result = JSON.parse(msg);
            if(result.error == 0){
               toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
            }else{
               toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
            }
            getTableData();
         }).fail(function(xhr, status, error) {
            toastr['error'](xhr + ' ' + status + ' ' + error, 'ERROR!', { positionClass: "toast-top-center" });
         });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
            toastr['warning']('Membatalkan Penghapusan stok', 'WARNING!', { positionClass: "toast-top-center" });
         }
      })
   }

   
   /* 
   // Update DataTables after Data Update
   */
   function getTableData(){
      if(table){
         table.destroy();
      }
      $.ajax({
         url: "/devs/api/barang",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);
         let dataset = [];

         result.forEach(item => {
            console.log(item);
            let temp = [];
            temp.push(item.kode_barang);
            temp.push(item.nama_barang);
            temp.push(item.stok);
            temp.push(item.satuan);
            temp.push(item.harga_beli);
            temp.push(item.harga_jual);
            temp.push(item.created_at.replace("T", " ").replace(".000000Z", ""));

            let button_html = `
               <div class="d-flex justify-content-center">
                  <a href="#" onclick="openEditModal(`+item.id+`)" class="mr-1" data-toggle="modal" data-target="#modal-edit"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                  <a href="#" onclick="sendDeleteRequest(`+item.id+`)" ><i class="badge-circle badge-circle-danger bx bx-trash-alt font-medium-1"></i></a>
               </div>
            `;
            temp.push(button_html);
            dataset.push(temp);
         });

         // CONSTRUCT DATATABLE
         table = $('#datatable').DataTable( {
            data: dataset,
            columns: [
               { title: "Kode" },
               { title: "Nama" },
               { title: "Stok" },
               { title: "Satuan" },
               { title: "Harga Beli",
                 render: $.fn.dataTable.render.number( '.', ',', 2, '')},
               { title: "Harga Jual",
                 render: $.fn.dataTable.render.number( '.', ',', 2, '')},
               { title: "Tgl. Dicatat" },
               { title: "Aksi" }
            ]
         } );
      });
   }

   function toggleForm(element){
      if($(element).attr('disabled') == "disabled") {
         $(element).prop( "disabled", false );
      } else {
         $(element).prop( "disabled", true );
      }
   }


   /* 
   // Emptiest the form value on Create Modal close
   */
   $("#default").on("hidden.bs.modal", function () {
      ['kode', 'nama', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
         $('#input-create-'+item).val("");
      });
   });
   

   /* 
   // Empties the form value on Edit Modal close
   // Disables kode barang and stok form input
   */
   $("#modal-edit").on("hidden.bs.modal", function () {
      ['kode', 'nama', 'stok', 'satuan', 'hargabeli', 'hargajual'].forEach(item =>{
         $('#input-edit-'+item).val("");
      });
      ['kode', 'stok'].forEach(item =>{
         $('#input-edit-'+item).prop( "disabled", true );
      });
   });


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

   // Import stok Ajax

   function ajaxUploadFile(){
      var file = $('#input-file')[0].files;
      console.log(file);
      if(file.length > 0){
         var fd = new FormData();

         // Append data 
         fd.append('file',file[0]);
         fd.append('_token', '{{ csrf_token() }}');

         // AJAX request 
         $.ajax({
           url: "{{ route('devs_import_stok') }}",
           method: 'post',
           data: fd,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               let result = response;
               
               if(result.error == 0){
                  toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
                  $('#import-stok-modal').modal('hide');
                  getTableData();
               }else{
                  toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
               }
           },
           error: function(response){
               toastr['error']('Terjadi kegagalan dalam upload file', 'ERROR!', { positionClass: "toast-top-center" });
           }
         });
      }else{
         toastr['error']('Pilih file terlebih dahulu', 'ERROR!', { positionClass: "toast-top-center" });
      }
   }

   // Export stok Ajax
   
   function ajaxDownloadFile(){
      $.ajax({
         url: '/devs/export_stok',
         type: 'GET',
         success: function() {
            window.location = '/devs/export_stok';
         }
      });
   }


   $(document).ready(function() {
      if(table){
         table.destroy();
      }
      getTableData();
   });
</script>
@endsection
