@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Manajemen Pegawai')
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
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="card">
         <div class="card-header justify-content-center">
            <h3 style="">Manajemen Pegawai</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-2">
            <div class="mr-auto float-left">
            </div>
            <div class="float-right">

            <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#import-pegawai-modal">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Import Pegawai
            </button>

               {{-- Import Pegawai Modal  --}}
               <div class="modal fade text-left" id="import-pegawai-modal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Import Pegawai</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form id="import-pegawai-form" method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Pilih file</label>
                                 <input id="input-file" type="file" class="form-control" name="file" placeholder="Pilih file" value="">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <button type="button" id="import-pegawai-button" onclick="ajaxUploadFile()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Import</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <button type="button" class="btn btn-primary bg-white round vert-top mr-2 block" data-toggle="modal" data-target="#default">
                  <i class="bx bx-plus"></i>&nbsp;&nbsp;Tambah Pegawai
               </button>

               {{-- Tambah Pegawai Modal  --}}
               <div class="modal fade text-left" id="default" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title" id="myModalLabel1">Tambah Pegawai</h3>
                           <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form method="#" action="#">
                              @csrf
                              <div class="form-group">
                                 <label for="roundText">Nama</label>
                                 <input id="input-create-nama" type="text" class="form-control" name="nama" placeholder="Nama Pegawai" value="">
                                 <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Alamat</label>
                                 <input id="input-create-alamat" type="text" class="form-control" name="alamat" placeholder="Alamat Pegawai" value="">
                                 <span id="invalid-create-feedback-alamat" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Nomor Telepon</label>
                                 <input id="input-create-hp" type="text" class="form-control" name="hp" placeholder="Nomor Telepon" value="">
                                 <span id="invalid-create-feedback-hp" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group gradient-child">
                                 <label for="roundText">Pilih Role</label>
                                 <select multiple="multiple" data-placeholder="Pilih role" name="roles[]" class="select2-icons form-control gradient" id="multiple-select2-icons" multiple="multiple">
                                    <option value="admin" data-icon="bx bxl-wordpress">Admin</option>
                                    <option value="gudang" data-icon="bx bxl-codepen">Gudang</option>
                                    <option value="kasir" data-icon="bx bxl-drupal" selected>Kasir</option>
                                    <option value="sales" data-icon="bx bxl-css3">Sales</option>
                                 </select>
                              </div>
                              
                              <div class="form-group">
                                 <label for="roundText">Username</label>
                                 <input id="input-create-username" type="text" class="form-control" name="username" placeholder="Username" value="">
                                 <span id="invalid-create-feedback-username" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              
                              <div class="form-group">
                                 <label for="roundText">Password</label>
                                 <input id="input-create-password" type="password" class="form-control" name="password" placeholder="Password">
                                 <span id="invalid-create-feedback-password" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <div class="form-group">
                                 <label for="roundText">Konfirmasi Password</label>
                                 <input id="input-create-password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
                                 <span id="invalid-create-feedback-password_confirmation" class="invalid-feedback" style="display: none;"></span>
                              </div>
                              <button type="button" id="create-pegawai-button" onclick="sendCreateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Tambahkan</button>
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

         {{-- Edit Pegawai Modal  --}}
         <div class="modal fade text-left" id="modal-edit" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="myModalLabel1">Edit Data Pegawai</h3>
                     <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form method="#" action="#">
                        @csrf
                        <div class="form-group">
                           <label for="roundText">Nama</label>
                           <input id="input-edit-nama" type="text" class="form-control" name="nama" placeholder="Nama Pegawai" value="">
                           <span id="invalid-edit-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Alamat</label>
                           <input id="input-edit-alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Alamat Pegawai" value="">
                           <span id="invalid-edit-feedback-alamat" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Nomor Telepon</label>
                           <input id="input-edit-hp" type="text" class="form-control" name="hp" placeholder="Nomor Telepon" value="">
                           <span id="invalid-edit-feedback-hp" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group gradient-child">
                           <label for="roundText">Pilih Role</label>
                           <select id="input-edit-role" multiple="multiple" data-placeholder="Pilih role" name="roles[]" class="form-control gradient">
                              <option id="option-edit-admin" value="admin" data-icon="bx bxl-wordpress">Admin</option>
                              <option id="option-edit-gudang" value="gudang" data-icon="bx bxl-codepen">Gudang</option>
                              <option id="option-edit-kasir" value="kasir" data-icon="bx bxl-drupal">Kasir</option>
                              <option id="option-edit-sales" value="sales" data-icon="bx bxl-css3">Sales</option>
                           </select>
                        </div>
                        
                        <div class="form-group">
                           <label for="roundText">Username</label>
                           <input id="input-edit-username" type="text" class="form-control" name="username" placeholder="Username" value="">
                           <span id="invalid-edit-feedback-username" class="invalid-feedback" style="display: none;"></span>
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
                              <th>No Hp</th>
                              <th>Tugas</th>
                              <th>Username</th>
                              <th>Tanggal Dicatat</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($pegawai as $item)
                              <tr>
                                 <td>{{$item->nama}}</td>
                                 <td>{{$item->alamat}}</td>
                                 <td>{{$item->hp}}</td>
                                 <td class="d-flex flex-wrap">
                                    {{-- Display Roles  --}}
                                    @foreach ($item->roles as $role)
                                      <button class="btn gradient" style="cursor: initial; padding: 0.25rem 0.5rem; margin: 0.25rem 0.25rem;">{{$role->nama}}</button>
                                    @endforeach
                                 </td>
                                 <td>{{$item->username}}</td>
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
                              <th>No Hp</th>
                              <th>Tugas</th>
                              <th>Username</th>
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
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
   let pegawai_id;
   let table;

   // Format Icon
   function iconFormat(icon) {
         let originalOption = icon.element;
         if (!icon.id) { return icon.text; }
         let $icon = "<i class='" + $(icon.element).data('icon') + "'></i>" + icon.text;

         return $icon;
   }

   // Open Edit Modal for Each Item
   function openEditModal(id){
      // alert(1);
      roles = ['kasir', 'admin', 'gudang', 'sales'];
      roles.forEach(element => {
         $('#option-edit-'+element).removeAttr("selected");
      });

      $.ajax({
         url: "/devs/api/pegawai/" + id,
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         pegawai_id = result.pegawai_data.id;
         $('#input-edit-nama').val(result.pegawai_data.nama);
         $('#input-edit-alamat').val(result.pegawai_data.alamat);
         $('#input-edit-hp').val(result.pegawai_data.hp);
         $('#input-edit-username').val(result.pegawai_data.username);
         
         result.pegawai_roles.forEach(element => {
            $('#option-edit-'+element).attr("selected", "selected");
         });
         
         console.log($("#input-edit-role"));

         $('#input-edit-role').select2({
            dropdownAutoWidth: true,
            width: '100%',
            minimumResultsForSearch: Infinity,
            templateResult: iconFormat,
            templateSelection: iconFormat,
            escapeMarkup: function(es) { return es; }
         });
      });
   };

   // Add Pegawai
   function sendCreateRequest(){
      let roles = [];
      $('.select2-selection__rendered').eq(0).children().each( (index, element) => {
         if(element.hasAttribute("title")){
            roles.push(element.getAttribute("title").toLowerCase());
         }
      });

      ['nama', 'alamat', 'hp', 'username', 'password', 'password_confirmation'].forEach(item =>{
         $('#input-create-'+item).removeClass("is-invalid");
         $('#invalid-create-feedback-'+item).html("");
         $('#invalid-create-feedback-'+item).hide();
      });

      $.ajax({
         url: "/devs/api/pegawai/create",
         type: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data: {
            '_token': '{{ csrf_token() }}',
            'nama': $('#input-create-nama').val(),
            'alamat': $('#input-create-alamat').val(),
            'hp': $('#input-create-hp').val(),
            'roles': roles,
            'username': $('#input-create-username').val(),
            'password': $('#input-create-password').val(),
            'password_confirmation': $('#input-create-password_confirmation').val(),
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
         ['nama', 'alamat', 'hp', 'username', 'password', 'password_confirmation'].forEach(item =>{
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
         toastr['error']('Terdapat Kesalahan Dalam Input Data Pegawai', 'ERROR!', { positionClass: "toast-top-center" });
      });
   }

   // Send the Update Request After Editing Pegawai Information
   function sendUpdateRequest(){
      let roles = [];
      $('.select2-selection__rendered').eq(1).children().each( (index, element) => {
         if(element.hasAttribute("title")){
            roles.push(element.getAttribute("title").toLowerCase());
         }
      });

      ['nama', 'alamat', 'hp', 'username', 'password', 'password_confirmation'].forEach(item =>{
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
         url: "/devs/api/pegawai/" + pegawai_id,
         method: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data : {
            '_token': '{{ csrf_token() }}',
            'nama': $('#input-edit-nama').val(),
            'alamat': $('#input-edit-alamat').val(),
            'hp': $('#input-edit-hp').val(),
            'roles': roles,
            'username': $('#input-edit-username').val(),
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
         toastr['error']('Terdapat Kesalahan Dalam Input Data Pegawai', 'ERROR!', { positionClass: "toast-top-center" });
      });
   }

   // Delete Pegawai
   function sendDeleteRequest(id){
      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-danger mr-1',
            cancelButton: 'btn btn-warning'
         },
         buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
         title: 'Non-Aktifkan Pegawai?',
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
               url: "/devs/api/pegawai/" + id,
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
            toastr['warning']('Membatalkan Penghapusan Pegawai', 'WARNING!', { positionClass: "toast-top-center" });
         }
      })
   }

   // Update DataTables after Data Update
   function getTableData(){
      if(table){
         table.destroy();
      }
      $.ajax({
         url: "/devs/api/pegawai",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);
         let dataset = [];

         result.forEach(item => {
            console.log(item);
            let temp = [];
            temp.push(item.pegawai_data.nama);
            temp.push(item.pegawai_data.alamat);
            temp.push(item.pegawai_data.hp);

            let roles_html = "";
            item.pegawai_roles.forEach(role =>{
               console.log("ROLE ::> ", role);
               roles_html += '<button class="btn gradient" style="cursor: initial; padding: 0.25rem 0.5rem; margin: 0.25rem 0.25rem;">'+ role +'</button>'
            });
            temp.push(roles_html);
            temp.push(item.pegawai_data.username);
            temp.push(item.pegawai_data.created_at.replace("T", " ").replace(".000000Z", ""));

            let button_html = `
               <div class="d-flex justify-content-center">
                  <a href="#" onclick="openEditModal(`+item.pegawai_data.id+`)" class="mr-1" data-toggle="modal" data-target="#modal-edit"><i class="badge-circle badge-circle-warning bx bx-pencil font-medium-1"></i></a>
                  <a href="#" onclick="sendDeleteRequest(`+item.pegawai_data.id+`)" ><i class="badge-circle badge-circle-danger bx bx-trash-alt font-medium-1"></i></a>
               </div>
            `;
            temp.push(button_html);
            dataset.push(temp);
         });

         // CONSTRUCT DATATABLE
         table = $('#datatable').DataTable( {
            data: dataset,
            columns: [
               { title: "NAMA" },
               { title: "ALAMAT" },
               { title: "NO HP" },
               { title: "TUGAS" },
               { title: "USERNAME" },
               { title: "TANGGAL DICATAT" },
               { title: "AKSI" }
            ]
         } );
      });
   }

   // Import Pegawai Ajax

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
           url: "{{ route('devs_import_pegawai') }}",
           method: 'post',
           data: fd,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               let result = response;
               
               if(result.error == 0){
                  toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
                  $('#import-pegawai-modal').modal('hide');
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

   // Export Pegawai Ajax
   
   function ajaxDownloadFile(){
      $.ajax({
         url: '/devs/export_pegawai',
         type: 'GET',
         success: function() {
            window.location = '/devs/export_pegawai';
         }
      });
   }

   // $(document).ajaxStop($.unblockUI);

   $(document).ready(function() {
      if(table){
         table.destroy();
      }
      getTableData();
   });
</script>
@endsection
