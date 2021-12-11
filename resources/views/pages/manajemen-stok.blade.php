@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Manajemen Stok')
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
            <h3 style="">Manajemen Stok</h3>
            @include("panels.back-button")
         </div>
         <div class="mx-2 mb-2">
            <div class="mr-auto float-left">
            </div>
            <div class="float-right"> 
               <button type="button" class="btn btn-primary bg-white round vert-top" id="save-file">
                  <i class="bx bx-download"></i>&nbsp;&nbsp;Simpan Dokumen
               </button>
            </div>
         </div>
         
         <hr class="my-0">

         {{-- Edit Stok Modal  --}}
         <div class="modal fade text-left" id="modal-edit" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="myModalLabel1">Edit Data Stok</h3>
                     <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form method="#" action="#">
                        @csrf
                        <div class="form-group">
                           <label for="roundText">Kode Barang</label>
                           <input id="input-edit-kode" type="text" disabled class="form-control" name="kode" placeholder="Kode Barang" value="">
                           <span id="invalid-edit-feedback-kode" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Nama Barang</label>
                           <input id="input-edit-nama" type="text" disabled class="form-control" name="nama" placeholder="Nama Barang" value="">
                           <span id="invalid-edit-feedback-nama" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Stok Saat Ini</label>
                           <input id="input-edit-stok-before" type="text" disabled class="form-control" name="stok" placeholder="Stok" value="">
                           <span id="invalid-edit-feedback-stok" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Tambahan Stok</label>
                           <input id="input-edit-stok-add" onchange="updateStokAfter()" onclick="resetInput('#input-edit-stok-add')" type="text" class="form-control" name="stok" placeholder="Stok" value="">
                           <span id="invalid-edit-feedback-stok" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Total Stok</label>
                           <input id="input-edit-stok-after" type="text" disabled class="form-control" name="stok" placeholder="Stok" value="">
                           <span id="invalid-edit-feedback-stok" class="invalid-feedback" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                           <label for="roundText">Satuan</label>
                           <input id="input-edit-satuan" type="text" disabled class="form-control" name="satuan" placeholder="Satuan" value="">
                           <span id="invalid-edit-feedback-satuan" class="invalid-feedback" style="display: none;"></span>
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
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Satuan</th>
                              <th>Stok</th>
                              <th>Tgl. Diubah</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($stok as $item)
                              <tr>
                                 <td>{{$item->kode_barang}}</td>
                                 <td>{{$item->nama_barang}}</td>
                                 <td>{{$item->satuan}}</td>
                                 <td>{{$item->stok}}</td>
                                 <td>{{$item->updated_at}}</td>
                                 <td>
                                    <div class="d-flex justify-content-center">
                                       <a href="#" onclick="openEditModal({{ $item->id }})" data-toggle="modal" data-target="#modal-edit"><i class="badge-circle badge-circle-warning bx bx-plus font-medium-1"></i></a>
                                    </div>
                                 </td>
                                 
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Satuan</th>
                              <th>Stok</th>
                              <th>Tgl. Diubah</th>
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
   let stok_id;
   let table;

   /*
      Open Edit Modal for Each Item
   */
   function openEditModal(id){
      $.ajax({
         url: "/devs/api/stok/" + id,
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         stok_id = result.id;
         $('#input-edit-kode').val(result.kode_barang);
         $('#input-edit-nama').val(result.nama_barang);
         $('#input-edit-stok-before').val(result.stok);
         $('#input-edit-stok-add').val(0);
         $('#input-edit-stok-after').val(result.stok)
         $('#input-edit-satuan').val(result.satuan);
      });
   };

   /* 
      Send the Update Request After Editing Stok Stok Information
   */
   function sendUpdateRequest(){
      ['stok'].forEach(item =>{
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
         url: "/devs/api/stok/" + stok_id,
         method: 'PUT',
         async: true,
         headers: { 'ITS': 'KKN Desa Tihingan' },
         data : {
            '_token': '{{ csrf_token() }}',
            'stok': $('#input-edit-stok-after').val()
         }
      }).done(function(msg) {
         let result = JSON.parse(msg);

         if(result.error == 0){
            toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
         } else {
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
         toastr['error']('Terdapat Kesalahan Dalam Input Data Stok', 'ERROR!', { positionClass: "toast-top-center" });
      });
   }

   // Update DataTables after Data Update
   function getTableData(){
      if(table){
         table.destroy();
      }
      $.ajax({
         url: "/devs/api/stok",
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
            temp.push(item.satuan);
            temp.push(item.stok);
            temp.push(item.updated_at.replace("T", " ").replace(".000000Z", ""));

            let button_html = `
               <div class="d-flex justify-content-center">
                  <a href="#" onclick="openEditModal(`+item.id+`)" data-toggle="modal" data-target="#modal-edit"><i class="badge-circle badge-circle-warning bx bx-plus font-medium-1"></i></a>
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
               { title: "Satuan" },
               { title: "Stok" },
               { title: "Tgl. Diubah" },
               { title: "Aksi" }
            ]
         } );
      });
   }



   /* 
      Update the after stok text
   */
   function updateStokAfter() {
      $('#input-edit-stok-after').val(Number($('#input-edit-stok-before').val()) + Number($('#input-edit-stok-add').val()));
   }



   /* 
      Reset Input On Click
   */
   function resetInput(id){
      $(id).val('');
   }


   
   /* 
      Barcode Scanning Listener
   */
  let code = "";
   document.addEventListener('keydown', e=>{
      let reading = false;
      if (e.keyCode === 13){
         table.search( code ).draw();

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

   $(document).ready(function() {
      if(table){
         table.destroy();
      }
      getTableData();
   });
</script>
@endsection
