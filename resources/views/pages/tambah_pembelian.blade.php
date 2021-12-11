@extends('layouts.fullLayoutMaster')
{{-- title --}}
@section('title','Kasir')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/plugins/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
@endsection

@section('header')
{{-- navabar --}}
{{-- @include('panels.back-header') --}}
@endsection

@section('content')
<div id="kasir-container" class="row mx-1 justify-content-center d-none d-lg-flex mt-2" style="min-height: 85vh;">
   <div class="col-12 mb-2">
      <div class="card h-100 p-1 mb-0">
         <div class="card-header justify-content-center">
            <h3 style="margin: 0;">Pembelian Baru</h3>
            @include("panels.back-button")
         </div>
         <div class="d-flex flex-row justify-content-end align-items-center mb-1">
            <div class="d-flex flex-row align-items-center ">
               <i class="bx bx-search mr-1"></i>
               <div class=" flex-grow-1">
                  <select id="barang-select" class="js-example-basic-single flex-grow-1" name="state">
                     <option value="" selected>- Pilih Barang -</option>
                     @foreach ($barang as $item)
                     <option value="{{$item->id}}">{{$item->kode_barang}}/{{$item->satuan}} - {{$item->nama_barang}}</option>
                     @endforeach
                  </select>
               </div>
               <!-- <input type="text" class="form-control ml-1" id="harga-beli" value="" placeholder="Harga Beli"> -->
               <input type="number" class="form-control ml-1" id="jumlah-ditambah" value="" placeholder="Jumlah">
               <button type="button" onclick="addBarang()" class="btn btn-primary bg-white round vert-top block ml-1">
                  <i class="bx bx-plus"></i>
               </button>
            </div>
         </div>
         <div class="card-body p-0">
            <div class="table-responsive p-0">
               <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                     <div class="col-12">
                        <table class="table zero-configuration" id="datatable">
                           <thead>
                              <tr>
                                 <th>Kode</th>
                                 <th>Nama</th>
                                 <th>Satuan</th>
                                 <th>Jumlah</th>
                                 <th>Harga</th>
                                 <th>Harga Total</th>
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>

                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-footer d-flex p-0">
            <div class="ml-auto">
               {{-- <button type="button" onclick="tambahTransaksiPembelian()" class="mr-1 btn btn-warning round bg-white text-center font-medium-3">Tambah Barang Baru</button> --}}
               <button type="button" onclick="pembelianPostRequest()" class="btn btn-success round bg-white text-center font-medium-3">Konfirmasi Pembelian</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row mx-3 justify-content-center d-block d-lg-none">
   <div class="card h-100 p-1 bg-warning text-center">
      <h1 class="m-0 px-1 text-white"><i class="bx bx-lg bx-tada bxs-error"></i></h1>
      <h1 class="m-0 px-1 text-white">Layar Terlalu Kecil Untuk Menampilkan Halaman Ini</h1>
   </div>
</div>

<!--/ CSS Classes -->

@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.min.js')}}"></script>
<script src="{{asset('js/scripts/extensions/toastr.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/numeral/numeral.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
   /* 
   // ENABLE/DISABLE Console Logs
   */
   var DEBUG = true;
   if (!DEBUG) {
      console.log = function() {}
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
   // On Document Ready Listener
   */
   $(document).ready(function() {
      $('#total-belanja').text("Rp. " + numeral(0).format('0.0[,]00'));

      $('#pelanggan-select').select2({
         placeholder: 'Pilih Pelanggan',
         allowClear: true
      });

      $('#barang-select').select2({
         placeholder: 'Cari Barang',
         allowClear: true
      });
      
      $('#kasir-container').css("min-height", window.outerHeight/5*4);
   });

   /* 
   // Global Variables
   */
   let barang = {!!json_encode($barang -> toArray()) !!}
   let user = {!!json_encode(Auth::user())!!}
   let listBarang = [];
   let total_belanja;
   let table = $('#datatable').DataTable({
      dom: 'rti',
      scrollY: '68vh',
      scrollCollapse: true,
      paging: false,
      ordering: false,
      info: false
   });



   function resetInput(html_id){
      console.log("resetInput called " + html_id);
      $(`${html_id}`).val('');
   }



   /*
   // Add Barang to ListBarang from Header Input
   */
   function addBarang() {
      let selected = $("#barang-select").select2('data');
      let curBar = barang.filter(function(e) {
         return e.id == selected[0].id
      });
      let found = listBarang.findIndex(element => element.id == curBar[0].id);
      // If current stock is not found in listBarang
      if (found == -1) {
         listBarang.push({
            id: curBar[0].id,
            kode_barang: curBar[0].kode_barang,
            nama_barang: curBar[0].nama_barang,
            satuan: curBar[0].satuan,
            harga_beli: curBar[0].harga_beli,
            jumlah: $('#jumlah-ditambah').val()
         });
      }
      // If current stock is found in listBarang 
      // and the buy price is same
      else {
         listBarang[found].jumlah = +listBarang[found].jumlah + +$('#jumlah-ditambah').val();
      }

      /* Empties Header Input */
      $("#barang-select").val(null).trigger('change');
      $('#jumlah-ditambah').val("");
      $('#harga-beli').val("");

      /* Reloads The Table */
      getTableData();
   };



   /* 
   // Refresh Table
   */
   function getTableData() {
      console.log("getTableData() called");
      total_belanja = 0;
      if (table) {
         table.destroy();
      }

      let dataset = [];

      listBarang.forEach((item, item_index) => {
         console.log(item);
         let temp = [];
         temp.push(item.kode_barang);
         temp.push(item.nama_barang);
         temp.push(item.satuan);
         let jumlah_html = `
            <div class="input-group">
               <span class="input-group-btn input-group-prepend">
                  <button onclick="updateItemValue(`+item_index+`, -1)" class="btn btn-warning py-0 px-1" type="button">-</button>
               </span>
               <input type="number" class="form-control text-center w-50 mx-auto" id="row-`+item_index+`-jml" onchange="updateItemQuantity(`+item_index+`)" name="row-`+item_index+`-jml" value="`+item.jumlah+`">
               <span class="input-group-btn input-group-append">
                  <button onclick="updateItemValue(`+item_index+`, 1)" class="btn btn-success py-0 px-1" type="button">+</button>
               </span>
            </div>
         `
         temp.push(jumlah_html);
         let beli_html = `
            <div class="input-group">
               <input type="number" class="form-control text-center w-50 mx-auto" id="row-`  +item_index+`-beli" onclick="resetInput('row-`+item_index+`-beli')" onchange="updateItemPrice(`+item_index+`)" name="row-`+item_index+`-beli" value="`+numeral(item.harga_beli).format('0,0')+`">
            <div class="input-group">
         `
         temp.push(beli_html);
         temp.push(item.harga_beli * item.jumlah);
         total_belanja += item.harga_beli * item.jumlah;
         let button_html = `
            <div class="d-flex justify-content-center">
               <a href="#" onclick="deleteItem(` + item_index + `)" ><i class="badge-circle badge-circle-danger bx bx-trash-alt font-medium-1"></i></a>
            </div>
         `;
         temp.push(button_html);
         dataset.push(temp);
      });

      //CONSTRUCT DATATABLE
      table = $('#datatable').DataTable({
         dom: 'rti',
         scrollY: '68vh',
         scrollCollapse: true,
         paging: false,
         ordering: false,
         info: false,
         data: dataset,
         columns: [{
               title: "Kode",
               width: "10%"
            },
            {
               title: "Nama",
               width: "20%"
            },
            {
               title: "Satuan",
               width: "1%"
            },
            {
               title: "Jumlah",
               width: "20%"
            },
            {
               title: "Harga",
               width: "17.5%"
            },
            {
               title: "Harga Total",
               width: "17.5%",
               render: $.fn.dataTable.render.number('.', ',', 2, '')
            },
            {
               title: "Aksi",
               width: "1%"
            }
         ]
      });
   }



   /* 
   // Delete Item From Table
   */
   function deleteItem(item_index) {
      // let index = listBarang.findIndex(element => element.id == id);
      console.log("Removed item "+ listBarang[item_index].nama_barang);
      listBarang.splice(item_index, 1);
      getTableData();
   }


   /*
   // Update Item Value on + or - Button Click
   */
   function updateItemValue(item_index, increment){
      console.log("updateItemValue called");
      listBarang[item_index].jumlah = Number($('#row-' + item_index + '-jml').val()) + increment;
      if(listBarang[item_index].jumlah <= 0){
         listBarang[item_index].jumlah = 1;
      }
      getTableData();
   }



   /*
   // Update Item Value on Textfield Input
   */
   function updateItemQuantity(item_index) {
      console.log("updateItemQuantity called");
      listBarang[item_index].jumlah = $('#row-' + item_index + '-jml').val();
      if(listBarang[item_index].jumlah <= 0){
         listBarang[item_index].jumlah = 1;
      }
      getTableData();
   }
   
   
   
   /*
   // Update Item Value on Textfield Input
   */
   function updateItemPrice(item_index) {
      console.log("updateItemPrice called");
      listBarang[item_index].harga_beli = $('#row-' + item_index + '-beli').val();
      listBarang[item_index].harga_beli = listBarang[item_index].harga_beli.replace(/\./, "")
      listBarang[item_index].harga_beli = listBarang[item_index].harga_beli.replace(/,{0*}/, "")
      if(listBarang[item_index].harga_beli <= 0){
         listBarang[item_index].harga_beli = 1;
      }
      getTableData();
   }



   /*
   // Send Create Request to PembelianController
   */
   function pembelianPostRequest(){
      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-success mr-1',
            cancelButton: 'btn btn-warning'
         },
         buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
         title: 'Tambahkan Transaksi Pembelian?',
         text: `Total Pembelian Rp. ${numeral(total_belanja).format('0.0[,]00')}`,
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Tambah',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
            url: "/devs/api/pembelian/create",
            method : 'PUT',
            async: true,
            headers: { 'ITS': 'KKN Desa Tihingan' },
            data : {
               '_token' : '{{ csrf_token() }}',
               'peg_id' : user.id,
               'status_bayar' : 1,
               'total_belanja' : total_belanja,
               'list_barang' : listBarang
            }
            }).done(function(msg) {
               let result = JSON.parse(msg);
               if(result.error > 0) {
                  Swal.fire(
                     'ERROR!',
                     result.message,
                     'error'
                  );
               } else {
                  Swal.fire({
                     title: `Pembelian Rp. ${numeral(total_belanja).format('0.0[,]00')}`,
                     text: `Data Pembelian Ditambahkan`,
                     icon: 'success',
                  });
                  resetTransaction();
               }
            });
         }
      })
   };



   /*
   // Reset transaction
   */
   function resetTransaction() {
      listBarang = [];
      $('#barang-select').val(null).trigger('change');
      $('#jumlah-ditambah').val("");
      getTableData();
   }



   /*
   // Barcode Scanning Listener
   */
   let code = "";
   document.addEventListener('keydown', e => {
      let reading = false;
      if (e.keyCode === 13) {
         if (code > 10) {
            let curBar = barang.filter(function(e) {
               return e.kode_barang == code
            });
            console.log(curBar);
            if (curBar.length === 0) {
               toastr.remove();
               toastr['error']('Barang Tidak Ditemukan', 'ERROR!', {
                  positionClass: "toast-top-full-width"
               });
               return;
            }
            let found = listBarang.findIndex(element => element.id == curBar[0].id);
            if (found == -1) {
               listBarang.push({
                  id: curBar[0].id,
                  kode_barang: curBar[0].kode_barang,
                  nama_barang: curBar[0].nama_barang,
                  satuan: curBar[0].satuan,
                  harga_beli: curBar[0].harga_beli,
                  jumlah: 1
               });
            } else {
               listBarang[found].jumlah = +listBarang[found].jumlah + +1;
            }

            /* EMPTIES THE SELECT2 AND JUMLAH INPUT */
            $('#barang-select').val(null).trigger('change');
            $('#jumlah-ditambah').val("");

            /* RELOAD THE TABLE */
            toastr.remove();
            toastr['success'](curBar[0].kode_barang + " - " + curBar[0].nama_barang, 'SCAN', {
               positionClass: "toast-top-full-width"
            });
            getTableData();
         }

         code = "";
      } else {
         code += e.key;
      }
      /* Timeout 200ms after the first read and clear everything */
      if (!reading) {
         reading = true;
         setTimeout(() => {
            console.log('[NaB]')
            code = "";
            reading = false;
         }, 200);
      }
   });


</script>
<style>
   html .navbar-static .app-content .content-wrapper {
      padding-top: 0.5rem;
   }

   .table th,
   .table td {
      padding: 0.5rem 1rem;
      vertical-align: middle;
      border-top: 1px solid #dfe3e7;
   }
</style>
@endsection
