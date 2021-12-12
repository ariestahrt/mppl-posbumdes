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
@include('panels.back-header')
@endsection

@section('content')
<div id="kasir-container" class="row mx-1 justify-content-center d-none d-lg-flex" style="min-height: 85vh;">
   <div class="col-md-9 mb-2">
      <div class="card h-100 p-1 mb-0">
         <div class="d-flex mainmenu-header mb-1 align-items-center">
            <div class="mr-auto justify-content-end">
            <img src="{{asset('images/backgrounds/pos_color.png')}}" alt="" style="width: 10rem;">
            </div>
            <div class="float-right d-flex justify-content-end align-items-center">
               <i class="bx bx-search mr-1"></i>
               <select id="barang-select" class="js-example-basic-single" name="state">
                  <option value="" selected>- Pilih Barang -</option>
                  @foreach ($barang as $item)
                  <option value="{{$item->id}}">{{$item->kode_barang}} - {{$item->nama_barang}}</option>
                  @endforeach
               </select>
               <input type="text" class="form-control w-25 mx-1" id="jumlah-ditambah" value="" placeholder="Jumlah">
               <button type="button" onclick="addBarang()" class="btn btn-primary bg-white round vert-top block">
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
      </div>
   </div>

   <div class="col-md-3 mb-2">
      <div class="h-100 mb-0">
         <div class="card p-1 mb-2">
            <div class="mainmenu-header">
               <h5 class="m-0">Pelanggan</h5>
            </div>
            <div class="card-body p-0 mt-1">
               <div class="d-flex flex-column p-0">
                  <div>
                     <!-- PILIH PELANGGAN DROPDOWN -->
                     <select id="pelanggan-select" class="w-75" name="state">
                        <option value="" selected>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                     </select>
                     <button type="button" class="d-flex btn btn-primary round bg-white btn-submit ml-auto mt-1 text-center" data-toggle="modal" data-target="#tambah-pelanggan">
                        <i class="bx bx-plus font-medium-1"></i>&nbsp;&nbsp;Pelanggan Baru
                     </button>
                     <div style="position: absolute;">
                     <iframe style="display: none;" id="printf" src=""></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card p-1 mb-2">
            <div class="mainmenu-header">
               <h5 class="m-0">Menu</h5>
            </div>
            <div class="d-flex card-body p-0 align-items-center mt-1">
               <div class="w-100">
                  <button type="button" onclick="resetTransaction()" class="w-100 d-flex btn btn-primary round bg-white btn-submit"><i class="bx bxs-trash-alt font-medium-1"></i>&nbsp;&nbsp;Batalkan Transaksi</button>
               </div>
            </div>
         </div>
         <div class="card p-1 mb-2">
            <div class="mainmenu-header">
               <h5 class="m-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body p-0 mt-1">
               <div class="mb-2 p-0">
                  <label for="">Total Belanja</label>
                  <h3 id="total-belanja" class="m-0" style="color: #8991D6;">Rp. 0</h3>
               </div>
               <button type="button"  data-toggle="modal" data-target="#bayar" onclick="initiateModalBayar()" class="w-100 btn btn-success round bg-white btn-submit text-center font-medium-5">Bayar</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row mx-3 justify-content-center d-block d-lg-none">
   <div class="card h-100 p-1 bg-warning text-center">
      <h1 class="m-0 px-1 text-white"><i class="bx bx-lg bx-tada bxs-error"></i></h1>
      <h1 class="m-0 px-1 text-white">Layar Terlalu Kecil Untuk Menampilkan Halaman Kasir</h1>
   </div>
</div>

{{-- Tambah Pelanggan Modal  --}}
<div class="modal fade text-left" id="tambah-pelanggan" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
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
                  <input id="input-create-nama" type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pelanggan" value="">
                  <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
               </div>
               <div class="form-group">
                  <label for="roundText">Alamat</label>
                  <input id="input-create-alamat" type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pelanggan" value="">
                  <span id="invalid-create-feedback-alamat" class="invalid-feedback" style="display: none;"></span>
               </div>
               <div class="form-group">
                  <label for="roundText">Nomor Telepon</label>
                  <input id="input-create-hp" type="text" class="form-control" name="hp" id="hp" placeholder="Nomor Telepon" value="">
                  <span id="invalid-create-feedback-hp" class="invalid-feedback" style="display: none;"></span>
               </div>
               <button type="button" id="create-pelanggan-button" onclick="sendCreateRequest()" class="btn btn-primary d-block round bg-white btn-submit mx-auto">Tambahkan</button>
            </form>
         </div>
      </div>
   </div>
</div>



{{-- Pembayaran Modal  --}}
<div class="modal fade text-left" id="bayar" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel1">Pembayaran</h3>
            <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
               <i class="bx bx-x"></i>
            </button>
         </div>
         <div class="modal-body">
            <form method="#" action="#">
               @csrf
               <div class="form-group">
                  <label for="roundText">Total Belanja</label>
                  <input id="input-bayar-total-belanja" type="text" class="form-control" name="total-belanja" placeholder="Total Belanja" value="" disabled>
                  <span id="invalid-create-feedback-nama" class="invalid-feedback" style="display: none;"></span>
               </div>
               <label for="roundText">Total Bayar</label>
               <div class="form-group input-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text">Rp.</span>
                  </div>
                  <input id="input-bayar-total-bayar" type="text" class="form-control" name="total-bayar" placeholder="Total Bayar" value="" onchange="calculateChange()" onclick="resetInputTotalBayar()">
                  <span id="invalid-create-feedback-total-bayar" class="invalid-feedback" style="display: none;"></span>
               </div>
               <fieldset class="mb-1 p-0">
                  <div class="custom-control custom-checkbox d-flex align-items-center">
                     <input type="checkbox" class="custom-control-input " onchange="checkBon()" name="customCheck" id="bon">
                     <label class="custom-control-label" style="font-size: 0.8rem; font-weight: 500;" for="bon">BON</label>
                  </div>
               </fieldset>
               <div class="form-group" id="keterangan" style="display: none;">
                  <label for="roundText">Keterangan</label>
                  <input id="input-bayar-keterangan" type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="">
                  <span id="invalid-create-feedback-keterangan" class="invalid-feedback" style="display: none;"></span>
               </div>
               <div class="mb-2 p-0">
                  <label for="">Kembalian</label>
                  <h4 id="input-bayar-kembalian" class="m-0" style="color: #8991D6;">Rp. 0</h4>
               </div>
               <!-- <div class="form-group">
                  <label for="roundText">Kembalian</label>
                  <input id="input-bayar-kembalian" type="text" class="form-control" name="kembalian" placeholder="Rp. " value="" disabled>
                  <span id="invalid-create-feedback-hp" class="invalid-feedback" style="display: none;"></span>
               </div> -->
               <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-danger d-block round bg-white btn-submit mr-2" data-dismiss="modal" aria-label="Close">Batalkan</button>
                  <button type="button" id="bayar-button" onclick="postBayarRequest()" class="btn btn-success d-block round bg-white btn-submit">Bayar</button>
               </div>
            </form>
         </div>
      </div>
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
      Global Variables
    */   
   let hargaTotal = 0;
   let total_bayar = 0;
   let kembalian = 0;
   let pelanggan = {!!json_encode($pelanggan -> toArray()) !!}
   let barang = {!!json_encode($barang -> toArray()) !!}
   let user = {!!json_encode(Auth::user())!!}

   let barangCount = 0;
   let listBarang = [];

   let table = $('#datatable').DataTable({
      dom: 'rti',
      scrollY: '68vh',
      scrollCollapse: true,
      paging: false,
      ordering: false,
      info: false
   });

   // ENABLE/DISABLE Console Logs
   var DEBUG = true;
   if (!DEBUG) {
      console.log = function() {}
   }

   function checkBon() {
      if($('#bon').is(':checked')) {
         $('#keterangan').show()
      } else {
         $('#keterangan').hide()
      }
   }




   let printInvoice = () => {
      document.getElementById("printf").contentWindow.print();
      Swal.fire(
         'Kembalian: Rp. ' + numeral(kembalian).format('0.0[,]00'),
         'Transaksi Sukses',
         'success'
      );
   }



   /*
   // Create Transaksi Penjualan on Database
   */
   function postBayarRequest(){
      if(!($('#bon').is(':checked')) && kembalian < 0) {
         toastr['error']("Uang tidak mencukupi!", 'ERROR!', { positionClass: "toast-top-center" });
      } else {
         let pel_id = $("#pelanggan-select").select2('data')[0].id;
         if (pel_id === "") pel_id = null;
         $.ajax({
            url: "/devs/api/kasir/bayar",
            method : 'PUT',
            async: true,
            headers: { 'ITS': 'KKN Desa Tihingan' },
            data : {
               '_token' : '{{ csrf_token() }}',
               'peg_id' : user.id,
               'pel_id' : pel_id,
               'status_bayar' : $('#bon').is(':checked') ? 0 : 1,
               'total_bayar' : total_bayar,
               'keterangan' : $('#bon').is(':checked') ? $('#input-bayar-keterangan').val() : "-",
               'list_barang' : listBarang
            }
         }).done(function(msg) {
            let result = JSON.parse(msg);
            if(result.error > 0) {
               $('#bayar').modal('hide');
               Swal.fire(
                  'ERROR!',
                  result.message,
                  'error'
               );
            } else {
               resetTransaction();
               $('#bayar').modal('hide');

               // let iframe = document.getElementById('printf');
               // iframe.src = `/devs/invoice/${result.id}`;
               // let ifWin = iframe.contentWindow || iframe;
               // iframe.focus();
               // ifWin.print();
               printPage(`/devs/invoice/${result.id}`);
               $("#pelanggan-select").val(null).trigger('change');
            }
         });
      }
   }
   
   // Print
   function closePrint () {
      document.body.removeChild(this.__container__);
   }

   function setPrint () {
      this.contentWindow.__container__ = this;
      this.contentWindow.onbeforeunload = closePrint;
      this.contentWindow.onafterprint = closePrint;
      this.contentWindow.focus(); // Required for IE
      this.contentWindow.print();
   }

   function printPage (sURL) {
      var oHideFrame = document.createElement("iframe");
      oHideFrame.onload = setPrint;
      oHideFrame.style.position = "fixed";
      oHideFrame.style.right = "0";
      oHideFrame.style.bottom = "0";
      oHideFrame.style.width = "0";
      oHideFrame.style.height = "0";
      oHideFrame.style.border = "0";
      oHideFrame.src = sURL;
      document.body.appendChild(oHideFrame);
   }

   // Bayar Button Clicked
   function initiateModalBayar(){
      total_bayar = 0;
      kembalian = total_bayar - hargaTotal;
      $('#input-bayar-total-belanja').val("Rp. " + numeral(hargaTotal).format('0.0[,]00'));
      $('#input-bayar-kembalian').html("Rp. " + numeral(total_bayar - hargaTotal).format('0.0[,]00'));
      if(total_bayar - hargaTotal < 0){
         $('#input-bayar-kembalian').css('color', '#ff5b5c');
      }else{
         $('#input-bayar-kembalian').css('color', '#8991D6');         
      }
      $('#input-bayar-total-bayar').val(numeral(total_bayar).format('0.0[,]00'));
   }

   // Event input-bayar-total-bayar on text 
   function calculateChange(){
      total_bayar = Number($('#input-bayar-total-bayar').val());
      kembalian = total_bayar - hargaTotal;
      $('#input-bayar-kembalian').html("Rp. " + numeral(total_bayar - hargaTotal).format('0.0[,]00'));
      if(total_bayar - hargaTotal < 0){
         $('#input-bayar-kembalian').css('color', '#ff5b5c');
      }else{
         $('#input-bayar-kembalian').css('color', '#8991D6');         
      }
      $('#input-bayar-total-bayar').val(numeral(total_bayar).format('0.0[,]00'));
   }

   function resetInputTotalBayar(){
      $('#input-bayar-total-bayar').val('');
   }

   /* 
      Numeral formatting
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
      Add Barang From Header Input
   */
   function addBarang() {
      let selected = $("#barang-select").select2('data');
      let curBar = barang.filter(function(e) {
         return e.id == selected[0].id
      });
      let found = listBarang.findIndex(element => element.id == curBar[0].id);
      if (found == -1) {
         listBarang.push({
            id: curBar[0].id,
            kode_barang: curBar[0].kode_barang,
            nama_barang: curBar[0].nama_barang,
            satuan: curBar[0].satuan,
            harga_jual: curBar[0].harga_jual,
            jumlah: $('#jumlah-ditambah').val()
         });
      } else {
         listBarang[found].jumlah = +listBarang[found].jumlah + +$('#jumlah-ditambah').val();
      }

      /* EMPTIES THE SELECT2 AND JUMLAH INPUT */
      $("#barang-select").val(null).trigger('change');
      $('#jumlah-ditambah').val("");

      /* RELOAD THE TABLE */
      getTableData();
   };

   /* 
      Plus / Minus 
   */   
   function updateItemValue(item_id, increment){
      let curBar = barang.filter(function(e) { return e.id == item_id });
      let found = listBarang.findIndex(element => element.id == curBar[0].id);
      
      listBarang[found].jumlah = Number($('#row-' + item_id + '-jml').val()) + increment;
      if(listBarang[found].jumlah <= 0){
         listBarang[found].jumlah = 1;
      }
      getTableData();
   }

   function updateItemQuantity(item_id) {
      console.log("updateItemQuantity called");
      let curBar = barang.filter(function(e) {
         return e.id == item_id
      });
      let found = listBarang.findIndex(element => element.id == curBar[0].id);
      listBarang[found].jumlah = $('#row-' + item_id + '-jml').val();
      if(listBarang[found].jumlah <= 0){
         listBarang[found].jumlah = 1;
      }
      getTableData();
   }

   /* 
      Pelanggan
   */   
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
         let result = JSON.parse(msg);
         
         if(result.error == 0){
            toastr['success'](result.message, 'Success', { positionClass: "toast-top-center" });
         } else {
            toastr['error'](result.message, 'ERROR!', { positionClass: "toast-top-center" });
         }

         ['nama', 'alamat', 'hp'].forEach(item =>{
            $('#input-create-'+item).val("");
         });

         getTableData();
         $('#tambah-pelanggan').modal('hide');
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
   };



   /* 
      Delete Item From Table
   */
   function deleteItem(id) {
      let index = listBarang.findIndex(element => element.id == id);
      console.log("Removed item "+ listBarang[index].nama_barang);
      listBarang.splice(index, 1);
      getTableData();
   }



   /* 
      New Transaction
   */
   function resetTransaction() {
      listBarang = [];
      $('#barang-select').val(null).trigger('change');
      $('#pelanggan-select').val(null).trigger('change');
      $('#total-belanja').text("Rp. " + numeral(0).format('0.0[,]00'));
      $('#jumlah-ditambah').val("");
      $('#input-create-nama').val("");
      $('#input-create-alamat').val("");
      $('#input-create-hp').val("");
      $('#input-bayar-total-bayar').val("");
      getTableData();
   }



   function getTableData() {
      console.log("getTableData() called");
      hargaTotal = 0;
      if (table) {
         table.destroy();
      }

      let dataset = [];

      listBarang.forEach(item => {
         console.log(item);
         let temp = [];
         temp.push(item.kode_barang);
         temp.push(`${item.nama_barang} - ${item.satuan}`);
         let jumlah_html = `
            <div class="input-group">
               <span class="input-group-btn input-group-prepend">
                  <button onclick="updateItemValue(`+item.id+`, -1)" class="btn btn-warning py-0 px-1" type="button">-</button>
               </span>
               <input type="number" class="form-control text-center w-50 mx-auto" id="row-`+item.id+`-jml" onchange="updateItemQuantity(`+item.id+`)" name="row-`+item.id+`-jml" value="`+item.jumlah+`">
               <span class="input-group-btn input-group-append">
                  <button onclick="updateItemValue(`+item.id+`, 1)" class="btn btn-success py-0 px-1" type="button">+</button>
               </span>
            </div>
         `
         temp.push(jumlah_html);
         temp.push(item.harga_jual);
         temp.push(item.harga_jual * item.jumlah);
         hargaTotal += item.harga_jual * item.jumlah;
         let button_html = `
            <div class="d-flex justify-content-center">
               <a href="#" onclick="deleteItem(` + item.id + `)" ><i class="badge-circle badge-circle-danger bx bx-trash-alt font-medium-1"></i></a>
            </div>
         `;
         temp.push(button_html);
         dataset.push(temp);
      });



      /* CONSTRUCT DATATABLE */
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
               title: "Jumlah",
               width: "20%"
            },
            {
               title: "Harga",
               width: "20%",
               render: $.fn.dataTable.render.number('.', ',', 2, '')
            },
            {
               title: "Harga Total",
               width: "20%",
               render: $.fn.dataTable.render.number('.', ',', 2, '')
            },
            {
               title: "Aksi",
               width: "1%"
            }
         ]
      });

      $("#total-belanja").text("Rp. " + numeral(hargaTotal).format('0.0[,]00'));

      $(".touchspin").TouchSpin({
         buttondown_class: "btn btn-warning",
         buttonup_class: "btn btn-success",
         min: 1,
         max: 999,
         stepinterval: 1000,
         stepintervaldelay: 1000
      });
   }



   /*
      Barcode Scanning Listener
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
                  harga_jual: curBar[0].harga_jual,
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
