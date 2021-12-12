@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Login')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection


@section('content')

<div class="login-bg">
   <img src="{{asset('images/backgrounds/bg_login.png')}}" alt="">
</div>
<div class="height-25vh">

</div>
<div class="row mx-3 justify-content-center">
   <div class="col-xl-4 col-md-6 col-sm-12">
      <div class="card gradient" style="position: relative;">
         <div class="card-header justify-content-center mt-5" id="login-header">
            <div style="position: absolute; bottom: 80%;">
               <img src="{{asset('images/cards/logo1.png')}}" alt="" style="width: 15rem;">
            </div>
            <h3 class="mt-1">POS BUMDES</h4>
         </div>
         <div class="card-body">
            <form class="form" onsubmit="return postInfo()">
               @csrf
               <div class="form-body">
                  <fieldset class="form-group">
                     <label for="roundText">Nama Pengguna</label>
                     <input type="text" name="username" id="username" class="form-control round" placeholder="Username">
                  </fieldset>
                  <fieldset class="form-group">
                     <label for="roundText">Kata Sandi</label>
                     <input type="password" name="password" id="password" class="form-control round" placeholder="Password">
                  </fieldset>
               </div>
               <div class="form-actions d-flex justify-content-center">
                  <a href="#">
                     <button type="submit" onclick="postInfo()" class="btn btn-primary-invert text-bold-600 round">Login</button>
                  </a>
               </div>
            </form>
         </div>
      </div>
   </div>


   <!--/ CSS Classes -->

   @endsection
   {{-- vendor scripts --}}
   @section('vendor-scripts')
   <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
   <script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
   <script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
   <script>
      function postInfo () {
         $.ajax({
               url: "/devs/login_pegawai",
               type: 'POST',
               async: false,
               headers: { 'ITS': 'KKN Desa Tihingan' },
               data: {
                  '_token': '{{ csrf_token() }}',
                  'username': $('#username').val(),
                  'password': $('#password').val(),
               }
            }).done(function(msg) {
               const result = JSON.parse(msg);
               console.log(result);
               
               if(result.error) {
                  toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
                  $('#username').val("");
                  $('#password').val("");
               } else {
                  window.location = '/devs/mainpage';
               }
            });
         return false;
      }
   </script>
   @endsection