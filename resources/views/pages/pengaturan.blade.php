@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Pengaturan')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
@endsection

@section('header')
{{-- navabar  --}}
<!-- @include('panels.back-header') -->
@endsection

@section('content')
</div>
<div class="row mx-3 justify-content-center">
   <div class="col-12">
      <div class="container">

         <div class="card">
            <div class="card-header justify-content-center">
               <h3 style="">Pengaturan</h3>
               @include("panels.back-button")
            </div>
            <div class="mx-2 mb-1">
               <div class="mr-auto float-left">
               </div>
               <div class="float-right">
                  <button type="button" class="btn btn-primary bg-white round vert-top" id="reset">
                     <i class="bx bx-reset"></i>&nbsp;&nbsp;Reset ke Pengaturan Awal
                  </button>
               </div>
            </div>
            <hr class="my-0">

            <!-- table bordered -->
            <div class="container mt-1 mb-2 px-3">

               <form method="POST" action="http://kkn.test/devs/create_pegawai">
                  @csrf
                  <div class="form-group">
                     <label for="roundText">Nama Toko</label>
                     <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pegawai" value="">
                  </div>
                  <div class="form-group">
                     <label class="roundText">Logo Toko</label>
                     <div class="row ">
                        <div class="col-xl-4 col-md-6 col-sm-12">
                           <div class="card ">
                              <img class="img-fluid" src="{{asset('images/cards/logo1.png')}}" alt="">
                           </div>
                        </div>
                     </div>
                     <div class="custom-file">
                        <input accept="image/*" type="file" class="custom-file-input" id="logo-input">
                        <label class="custom-file-label" for="logo-input">Unggah Gambar/Logo Toko</label>
                     </div>
                     <!-- <input type='file' name='file' class="form-control"> -->
                     @if ($errors->has('file'))
                     <span class="errormsg text-danger">{{ $errors->first('file') }}</span>
                     @endif
                  </div>
                  <div class="form-group">
                     <label for="roundText">Alamat</label>
                     <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pegawai" value="">
                  </div>
                  <div class="form-group">
                     <label for="roundText">Nomor Telepon</label>
                     <input type="text" class="form-control" name="hp" id="hp" placeholder="Nomor Telepon" value="">
                  </div>
                  <button type="submit" class="btn btn-success round btn-submit float-right">Simpan</button>
                  <a href="{{route('devs_get_mainpage')}}" class="mr-2 float-right ml-auto">
                     <button type="" class="btn btn-danger round btn-submit">Batalkan</button>
                  </a>
               </form>
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
   <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
   <script>
      $(document).ready(function() {
         $('#datatable').DataTable();
      });

      $('#save-file').click(function() {
         alert("Simpan Dokumen");
      });

      $('#find').click(function() {
         alert("Cari Diklik");
      });
   </script>
   @endsection