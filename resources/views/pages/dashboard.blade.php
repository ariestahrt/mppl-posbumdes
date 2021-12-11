@extends('layouts.fullLayoutMaster')
{{-- page Title --}}
@section('title','Dashboard E-commerce')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection

@section('header')
{{-- navabar --}}
@include('panels.back-header')
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
<div class="row">

   <div class="col-6 mb-2" id="card-dashboard">
      <div class="card h-100">
        <div class="card-body p-0">
            <div class="row m-0 align-items-center p-1">
               <h2 class="m-0" style="font-size: 1.5rem;">Grafik Penjualan:&nbsp;&nbsp;&nbsp;</h2>
               <div class="w-50">
                  <input type="text" class="custom-select" name="daterange-penjualan" id="daterange-penjualan" value=""/>
               </div>
            </div>
            <div id="penjualan-chart" style="min-height: 365px;">
            </div>
        </div>
      </div>
   </div>

   <div class="col-6 mb-2" id="card-dashboard">
      <div class="card h-100">
        <div class="card-body p-0">
            <div class="row m-0 align-items-center p-1">
               <h2 class="m-0" style="font-size: 1.5rem;">Grafik Pembelian:&nbsp;&nbsp;&nbsp;</h2>
               <div class="w-50">
                  <input type="text" class="custom-select" name="daterange-pembelian" id="daterange-pembelian" value=""/>
               </div>
            </div>
            <div id="pembelian-chart" style="min-height: 365px;">
            </div>
        </div>
      </div>
   </div>
</div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/numeral/numeral.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
   var today = new Date();
   var dd = String(today.getDate()).padStart(2, '0');
   var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
   var yyyy = today.getFullYear();



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
   // Update Penjualan Chart
   */
   let penjualanChart; 
   function updatePenjualanChart(penjualanStart, penjualanEnd) {
      if(penjualanChart) penjualanChart.destroy();

      let penjualanData = []
      let penjualanCategories = []
      $.ajax({
         url: "/devs/api/dashboard_penjualan/"+penjualanStart+"/"+penjualanEnd+"/",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);

         for(let i in result.data) {
            // console.log(result.data[i])
            // console.log(i)
            penjualanData.push(result.data[i])
            penjualanCategories.push(i)
         }
      });

      let options = {
         colors:['#66DD99'],
         series: [{
            name: 'Penjualan',
            data: penjualanData
         }],
         chart: {
            type: 'bar',
            height: 350
         },
         plotOptions: {
            bar: {
               horizontal: false,
               columnWidth: '55%',
            },
         },
         dataLabels: {
            enabled: false
         },
         stroke: {
            show: true,
            width: 2,
            colors: ['transparent'],
         },
         xaxis: {
            categories: penjualanCategories,
         },
         yaxis: {
            title: {
               text: 'Rupiah',
               style: {
                  fontSize: '14px',
                  color: '#666666',
               }
            }
         },
         fill: {
            opacity: 1
         },
         tooltip: {
            y: {
               formatter: function (val) {
               return "Rp. " + numeral(val).format('0.0[,]') + ""
               }
            }
         }
      };

      penjualanChart = new ApexCharts(document.querySelector("#penjualan-chart"), options);
      penjualanChart.render();
   }   



   /*
   // Update Pembelian Chart
   */
   let pembelianChart; 
   function updatePembelianChart(pembelianStart, pembelianEnd) {
      if(pembelianChart) pembelianChart.destroy();

      let pembelianData = []
      let pembelianCategories = []
      $.ajax({
         url: "/devs/api/dashboard_pembelian/"+pembelianStart+"/"+pembelianEnd+"/",
         async: false,
         headers: { 'ITS': 'KKN Desa Tihingan' }
      }).done(function(msg) {
         const result = JSON.parse(msg);
         console.log(result);

         for(let i in result.data) {
            // console.log(result.data[i])
            // console.log(i)
            pembelianData.push(result.data[i])
            pembelianCategories.push(i)
         }
      });

      let options = {
         colors:['#FF9966'],
         series: [{
            name: 'Pembelian',
            data: pembelianData,
         }],
         chart: {
            type: 'bar',
            height: 350
         },
         plotOptions: {
            bar: {
               horizontal: false,
               columnWidth: '55%',
            },
         },
         dataLabels: {
            enabled: false
         },
         stroke: {
            show: true,
            width: 2,
            colors: ['transparent'],
         },
         xaxis: {
            categories: pembelianCategories,
         },
         yaxis: {
            title: {
               text: 'Rupiah',
               style: {
                  fontSize: '14px',
                  color: '#666666',
               }
            }
         },
         fill: {
            opacity: 1
         },
         tooltip: {
            y: {
               formatter: function (val) {
               return "Rp. " + numeral(val).format('0.0[,]') + ""
               }
            }
         }
      };

      pembelianChart = new ApexCharts(document.querySelector("#pembelian-chart"), options);
      pembelianChart.render();
   }   



   /*
   // 
   */
   $(document).ready(function() {
      $(function() {
         $('input[name="daterange-penjualan"]').daterangepicker({
            opens: 'left',
            applyButtonClasses: 'btn-primary-invert',
            locale: {
               format: "DD/MM/YYYY",
               separator: " - ",
               applyLabel: "Cari",
               cancelLabel: "Batalkan",
               fromLabel: "Dari",
               toLabel: "Sampai",
               customRangeLabel: "Custom",
               weekLabel: "W",
               daysOfWeek: [
                     "Min",
                     "Sen",
                     "Sel",
                     "Rab",
                     "Kam",
                     "Jum",
                     "Sab"
               ],
               monthName: [
                     "January",
                     "February",
                     "March",
                     "April",
                     "May",
                     "June",
                     "July",
                     "August",
                     "September",
                     "October",
                     "November",
                     "December"
               ],
               firstDay: 1
            },
            startDate: '01' + '/' + mm + '/' + yyyy,
            endDate: dd + '/' + mm + '/' + yyyy
         }, function(start, end, label) {
            global_start_date = start.format('DD-MM-YYYY');
            global_end_date = end.format('DD-MM-YYYY');
            
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
            updatePenjualanChart(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'))
         });
      });

      $(function() {
         $('input[name="daterange-pembelian"]').daterangepicker({
            opens: 'left',
            applyButtonClasses: 'btn-primary-invert',
            locale: {
               format: "DD/MM/YYYY",
               separator: " - ",
               applyLabel: "Cari",
               cancelLabel: "Batalkan",
               fromLabel: "Dari",
               toLabel: "Sampai",
               customRangeLabel: "Custom",
               weekLabel: "W",
               daysOfWeek: [
                     "Min",
                     "Sen",
                     "Sel",
                     "Rab",
                     "Kam",
                     "Jum",
                     "Sab"
               ],
               monthName: [
                     "January",
                     "February",
                     "March",
                     "April",
                     "May",
                     "June",
                     "July",
                     "August",
                     "September",
                     "October",
                     "November",
                     "December"
               ],
               firstDay: 1
            },
            startDate: '01' + '/' + mm + '/' + yyyy,
            endDate: dd + '/' + mm + '/' + yyyy
         }, function(start, end, label) {
            global_start_date = start.format('DD-MM-YYYY');
            global_end_date = end.format('DD-MM-YYYY');
            
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
            updatePembelianChart(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'))
         });
      });

      setTimeout(function(){
         let rentang_tanggal = $('#daterange-penjualan').val();
         const tanggal = rentang_tanggal.split(" - ");

         global_start_date = tanggal[0].replace(/\//g, '-');
         global_end_date = tanggal[1].replace(/\//g, '-');

         updatePenjualanChart(tanggal[0].replace(/\//g, '-'), tanggal[1].replace(/\//g, '-'));
         updatePembelianChart(tanggal[0].replace(/\//g, '-'), tanggal[1].replace(/\//g, '-'));
      }, 300);
   });
</script>
@endsection
