@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Manajemen Pelanggan')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
@endsection

@section('header')
{{-- navabar  --}}
{{-- @include('panels.back-header') --}}
@endsection

@section('content')
</div>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3 style="">Manajemen Pelanggan</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-2">
            <div class="mr-auto float-left">
            </div>
            <div class="float-right">
            <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#import-pelanggan-modal">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Import Pelanggan
            </button>

               {{-- Import Pelanggan Modal  --}}
               <div class="modal fade text-left" id="import-pelanggan-modal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Import Pelanggan</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form id="import-pelanggan-form" method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Pilih file</label>
                                 <input id="input-file" type="file" class="form-control" name="file" placeholder="Pilih file" value="">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <button type="button" id="import-pelanggan-button" onclick="ajaxUploadFile()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Import</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#default">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Tambah Pelanggan
               </button>
               {{-- Tambah Pelanggan Modal  --}}
               <div class="modal fade text-left" id="default" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Tambah Pelanggan</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Nama</label>
                                 <input id="input-create-nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Nama Pelanggan" value="{{old('nama')}}">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Alamat</label>
                                 <input id="input-create-alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Alamat Pelanggan" value="{{old('alamat')}}">
                                 <span id="invalid-create-feedback-alamat" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Nomor Telepon</label>
                                 <input id="input-create-hp" type="text" class="form-control @error('hp') is-invalid @enderror" name="hp" id="hp" placeholder="Nomor Telepon" value="{{old('hp')}}">
                                 <span id="invalid-create-feedback-hp" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <button type="button" id="create-pelanggan-button" onclick="sendCreateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Tambahkan</button>
                           </form>
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

         <div class="modal fade text-left" id="modal-edit" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="myModalLabel1">Edit Data Pelanggan</h3>
                     <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form method="#" action="#">
                        @csrf
                        <div class="form-group">
                           <label for="roundText">Nama</label>
                           <input id="input-edit-nama" type="text" class="form-control" name="nama" placeholder="Nama Pelanggan" value="">
                           <span id="invalid-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Alamat</label>
                           <input id="input-edit-alamat" type="text" class="form-control" name="alamat" placeholder="Alamat Pelanggan" value="">
                           <span id="invalid-feedback-alamat" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Nomor Telepon</label>
                           <input id="input-edit-hp" type="text" class="form-control" name="hp" placeholder="Nomor Telepon" value="">
                           <span id="invalid-feedback-hp" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <button type="button" onclick="sendUpdateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Simpan</button>
                     </form>
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
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>Hp</th>
                              <th>Total Transaksi</th>
                              <th>Total Belanja</th>
                              <th>Tanggal Dicatat</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pelanggan as $item)
                              <tr>
                                 <td>{{$item->nama}}</td>
                                 <td>{{$item->alamat}}</td>
                                 <td>{{$item->hp}}</td>
                                 <td>{{$item->total_transaksi}}</td>
                                 <td>{{$item->total_belanja}}</td>
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
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>Hp</th>
                              <th>Total Transaksi</th>
                              <th>Total Belanja</th>
                              <th>Tanggal Dicatat</th>
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
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/file-uploaders/dropzone.min.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>


<script>
   let table;

   function openEditModal(id){
      $.ajax({
         url: "/devs/api/pelanggan/" + id,
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);
         pelanggan_id = result.id;
         $('#input-edit-nama').val(result.nama);
         $('#input-edit-alamat').val(result.alamat);
         $('#input-edit-hp').val(result.hp);
      });
   };

   
   // Add Pelanggan
   function sendCreateRequest(){
      ['nama', 'alamat', 'hp'].forEach(item =>{
         $('#input-create-'+item).removeClass("is-invalid");
         $('#invalid-create-feedback-'+item).html("");
         $('#invalid-create-feedback-'+item).hide();
      });

      $.ajax({
         url: "/devs/api/pelanggan/create",
         type: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data: {
            '_token': '{{ csrf_token() }}',
            'nama': $('#input-create-nama').val(),
            'alamat': $('#input-create-alamat').val(),
            'hp': $('#input-create-hp').val()
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
         ['nama', 'alamat', 'hp'].forEach(item =>{
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
         toastr['error'](xhr + ' ' + status + ' ' + error, 'ERROR!', { positionClass: "toast-top-center" });
      });
   }


   // Send the Update Request After Editing Pelanggan Information
   function sendUpdateRequest(){
      ['nama', 'alamat', 'hp'].forEach(item =>{
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
         url: "/devs/api/pelanggan/" + pelanggan_id,
         method: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data : {
         '_token': '{{ csrf_token() }}',
         'nama': $('#input-edit-nama').val(),
         'alamat': $('#input-edit-alamat').val(),
         'hp': $('#input-edit-hp').val(),
      }
      }).done(function(msg) {
         let result = JSON.parse(msg);
         if(result.error == 0){
            toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
         }else{
            toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
         }
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
         toastr['error'](xhr + ' ' + status + ' ' + error, 'ERROR!', { positionClass: "toast-top-center" });
      });
   }

   // Delete Pelanggan
   function sendDeleteRequest(id){
      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-danger mr-1',
            cancelButton: 'btn btn-warning'
         },
         buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
         title: 'Hapus Pelanggan?',
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
               url: "/devs/api/pelanggan/" + id,
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
            toastr['warning']('Membatalkan Penghapusan Pelanggan', 'WARNING!', { positionClass: "toast-top-center" });
         }
      })
   }

   // Update DataTables after Data Update
   function getTableData(){
      console.log("Get Table Data");
      if(table){
         table.destroy();
      }
      $.ajax({
         url: "/devs/api/pelanggan",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);
         let dataset = [];

         result.forEach(item => {
            console.log(item);
            let temp = [];
            temp.push(item.nama);
            temp.push(item.alamat);
            temp.push(item.hp);
            temp.push(item.total_transaksi);
            temp.push(item.total_belanja);
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
               { title: "Nama" },
               { title: "Alamat" },
               { title: "Hp" },
               { title: "Total Transaksi" },
               { title: "Total Belanja",
                 render: $.fn.dataTable.render.number('.', ',', 2, '') },
               { title: "Tanggal Dicatat" },
               { title: "Aksi" }
            ]
         } );
      });
   }

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
           url: "{{ route('devs_import_pelanggan') }}",
           method: 'post',
           data: fd,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               let result = response;
               
               if(result.error == 0){
                  toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
                  $('#import-pelanggan-modal').modal('hide');
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

   // Export pelanggan Ajax
   
   function ajaxDownloadFile(){
      $.ajax({
         url: '/devs/export_pelanggan',
         type: 'GET',
         success: function() {
            window.location = '/devs/export_pelanggan';
         }
      });
   }


   $(document).ready(function() {
      if(table){
         table.destroy();
      }
      getTableData();
      $("div#input-import-file").dropzone({ url: "/file/post" });
   });
</script>
@endsection