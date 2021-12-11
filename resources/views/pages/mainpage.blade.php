@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Mainpage')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
@endsection

@section('header')
{{-- navbar  --}}
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu" style="background: rgba(0,0,0,0);">
   <div class="navbar-wrapper mt-2">
      <div class="navbar-container content px-3">
         <div class="navbar-collapse" id="navbar-mobile">
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
            <img src="{{asset('images/backgrounds/pos.png')}}" alt="" style="width: 10rem;">
            </div>
            <ul class="nav navbar-nav float-right">
               <li class="nav-item">
                  <a href="{{route('devs_logout_pegawai')}}">
                     <button type="button" class="nav-item btn btn-primary round"><i class="bx bx-exit"></i> LOGOUT</button>
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</nav>
@endsection

@section('content')
<div class="mb-2 justify-content-center d-flex">
   <h2 class="text-white text-bold-600" id="welcome-message">Selamat Datang, {{ $nama }}!</h2>
</div>
<div class="row mx-3 justify-content-center">
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-dashboard">
      <a href="{{route('devs_get_dashboard')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/dashboard.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Dashboard</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-penjualan">
      <a href="{{route('devs_get_penjualan')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/penjualan.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Penjualan</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-pembelian">
      <a href="{{route('devs_get_pembelian')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/pembelian.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Pembelian</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (false)
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-transaksi-pembelian">
      <a href="{{route('devs_get_transaksi_pembelian')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <!-- <img src="{{asset('images/icon/cup.png')}}" height="125" width="125" class="img-fluid" alt="Dashboard Ecommerce" /> -->
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Transaksi Pembelian</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-aliran-stok">
      <a href="{{route('devs_get_aliran_stok')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/aliran_stok.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Aliran Stok</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-manajemen-barang">
      <a href="{{route('devs_get_manajemen_barang')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/manajemen_stok.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Manajemen Barang</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-manajemen-pegawai">
      <a href="{{route('devs_get_manajemen_pegawai')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/manajemen_pegawai.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Manajemen Pegawai</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-manajemen-pelanggan">
      <a href="{{route('devs_get_manajemen_pelanggan')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/manajemen_pelanggan.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Manajemen Pelanggan</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (false)
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-tambah-stok">
      <a href="{{route('devs_get_tambah_stok')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <img src="{{asset('images/icon/cup.png')}}" height="125" width="125" class="img-fluid" alt="Dashboard Ecommerce" />
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Tambah Stok</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (in_array("admin", $roles) || in_array("kasir", $roles))
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-kasir">
      <a href="{{route('devs_get_kasir')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/kasir.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Kasir</h5>
            </div>
         </div>
      </a>
   </div>
   @endif
   
   @if (false)
   <div class="col-xl-2 col-lg-4 col-sm-6 dashboard-greetings mb-2" id="card-pengaturan">
      <a href="{{route('devs_get_pengaturan')}}">
         <div class="card h-100">
            <div class="card-body px-1 pt-1 pb-0 d-flex flex-column justify-content-center align-items-center">
               <div class="d-flex justify-content-center align-items-center">
                  <div class="dashboard-content-center">
                     <svg data-src="{{asset('images/icon/kasir.svg')}}" class="text-success" width="125" height="125" data-cache="disabled"></svg>
                     <img src="{{asset('images/icon/cup.png')}}" height="125" width="125" class="img-fluid" alt="Dashboard Ecommerce" />
                  </div>
               </div>
            </div>
            <div class="card-header pt-0 mainmenu-header justify-content-center">
               <h5 class="greeting-text">Pengaturan</h5>
            </div>
         </div>
      </a>
   </div>
   @endif

   <!--/ CSS Classes -->

   @endsection
   {{-- vendor scripts --}}
   @section('vendor-scripts')
   <script src="{{asset('js/scripts/svg-loader.min.js')}}"></script>
   <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
@endsection