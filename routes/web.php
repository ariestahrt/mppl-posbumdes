<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROUTE PALING TENGET
Route::get('/devs/install', [PegawaiController::class, 'initiate_admin'])->name('devs_install');


Route::get('/', function () {
    return view('pages.login');
})->name('login');

Route::get('/devs/mainpage', [PegawaiController::class, 'api_get_account_info'])->name('devs_get_mainpage');

Route::get('/devs/pengaturan', function () {
    return view('pages.pengaturan');
})->name('devs_get_pengaturan');

Route::get('/devs/dashboard', function () {
    return view('pages.dashboard');
})->name('devs_get_dashboard');



/*
| 
| BEGIN PENJUALAN ROUTING
| 
*/

Route::get('/devs/penjualan', [PenjualanController::class, 'index'])->name('devs_get_penjualan');
Route::get('/devs/penjualan/{id}', [PenjualanController::class, 'get_detail_penjualan'])->name('devs_get_detail_penjualan');

    // PENJUALAN API ROUTING
    Route::get('/devs/api/penjualan/{start}/{end}', [PenjualanController::class, 'api_get_penjualan'])->name('devs_api_get_penjualan');
    Route::get('/devs/api/bon_penjualan/{id}', [PenjualanController::class, 'api_get_penjualan_bon'])->name('devs_api_get_penjualan_bon');
    Route::post('/devs/api/bon_penjualan/update', [PenjualanController::class, 'api_get_penjualan_update_bon'])->name('devs_api_get_penjualan_update_bon');

    // EXPORT
    Route::get('/devs/export/penjualan/{start}/{end}', [ImportExportController::class, 'ExportPenjualan'])->name('devs_export_penjualan');
/*
| 
| END PENJUALAN ROUTING
| 
*/



/*
| 
| BEGIN PEMBELIAN ROUTING
| 
*/

Route::get('/devs/pembelian', [PembelianController::class, "index_pembelian"])->name('devs_get_pembelian');
Route::get('/devs/tambah_pembelian', [PembelianController::class, "index_tambah_pembelian"])->name('devs_get_tambah_pembelian');
Route::get('/devs/pembelian/{id}', [PembelianController::class, 'get_detail_pembelian'])->middleware('auth', 'admin')->name('devs_get_detail_pembelian');

    // PEMBELIAN API ROUTING
    Route::put('/devs/api/pembelian/create', [PembelianController::class, "api_create_pembelian"])->name('devs_api_create_transaksi_pembelian');
    Route::get('/devs/api/pembelian/{start}/{end}', [PembelianController::class, 'api_get_pembelian'])->name('devs_api_get_pembelian');
    Route::put('/devs/api/pembelian/{id}', [PembelianController::class, 'api_update_pembelian'])->name('devs_api_update_pembelian');
    Route::get('/devs/api/det_pembelian/{id}', [PembelianController::class, 'api_get_detail_pembelian'])->name('devs_api_get_detail_pembelian');

/*
| 
| END PEMBELIAN ROUTING
| 
*/



/*
| 
| BEGIN PEGAWAI ROUTING
| 
*/

Route::get('/devs/manajemen_pegawai', [PegawaiController::class, "index"])->name('devs_get_manajemen_pegawai');
Route::get('/devs/login_pegawai', [PegawaiController::class, 'devs_login']);
Route::post('/devs/login_pegawai', [PegawaiController::class, 'devs_auth'])->name('devs_post_login_pegawai');
Route::get('/devs/logout_pegawai', [PegawaiController::class, 'devs_logout'])->name('devs_logout_pegawai');

    // PEGAWAI API ROUTING

    Route::put('/devs/api/pegawai/create', [PegawaiController::class, 'create'])->name('devs_api_create_pegawai');
    Route::put('/devs/api/pegawai/{id}', [PegawaiController::class, 'update_user_info'])->middleware('auth', 'admin')->name('devs_api_update_pegawai');
    Route::get('/devs/api/pegawai/{id}', [PegawaiController::class, 'get_pegawai'])->middleware('auth', 'admin')->name('devs_api_get_pegawai');
    Route::get('/devs/api/pegawai', [PegawaiController::class, 'get_all_pegawai'])->middleware('auth', 'admin')->name('devs_api_get_all_pegawai');
    Route::delete('/devs/api/pegawai/{id}', [PegawaiController::class, 'destroy'])->middleware('auth', 'admin')->name('devs_post_destroy_pegawai');
    Route::get('/devs/api/account', [PegawaiController::class, 'api_get_account_info'])->name('devs_api_get_account_info');


    // EXPORT || IMPORT
    Route::get('/devs/export_pegawai', [ImportExportController::class, 'ExportPegawai'])->name('devs_export_pegawai');
    Route::post('/devs/import_pegawai', [ImportExportController::class, 'ImportPegawai'])->name('devs_import_pegawai');

/*
| 
| END PEGAWAI ROUTING
| 
*/



/*
| 
| BEGIN ADMIN ROUTING
| 
*/

Route::get('/devs/admin_only', function () {
    return "You are an admin!";
})->middleware('auth', 'admin');

Route::get('/devs/404', function () {
    return "Oops! Page Not Found";
});

/*
| 
| END ADMIN ROUTING
| 
*/


/*
| 
| BEGIN PELANGGAN ROUTING
| 
*/

Route::get('/devs/manajemen_pelanggan',[PelangganController::class, 'index'])->middleware('auth', 'admin')->name('devs_get_manajemen_pelanggan');

    // PELANGGAN API ROUTING

    Route::put('/devs/api/pelanggan/create', [PelangganController::class, 'create'])->middleware('auth', 'admin')->name('devs_api_create_pelanggan');
    Route::put('/devs/api/pelanggan/{id}', [PelangganController::class, 'update_pelanggan_info'])->middleware('auth', 'admin')->name('devs_api_update_pelanggan');
    Route::get('/devs/api/pelanggan/{id}', [PelangganController::class, 'get_pelanggan'])->middleware('auth', 'admin')->name('devs_api_get_pelanggan');
    Route::get('/devs/api/pelanggan', [PelangganController::class, 'get_all_pelanggan'])->middleware('auth', 'admin')->name('devs_api_get_all_pelanggan');
    Route::delete('/devs/api/pelanggan/{id}', [PelangganController::class, 'destroy'])->middleware('auth', 'admin')->name('devs_post_destroy_pelanggan');

    // EXPORT || IMPORT
    Route::get('/devs/export_pelanggan', [ImportExportController::class, 'ExportPelanggan'])->name('devs_export_pelanggan');
    Route::post('/devs/import_pelanggan', [ImportExportController::class, 'ImportPelanggan'])->name('devs_import_pelanggan');
    
/*
| 
| END PELANGGAN ROUTING
| 
*/



/*
| 
| BEGIN BARANG ROUTING
| 
*/

Route::get('/devs/manajemen_barang',[BarangController::class, 'index'])->middleware('auth', 'admin')->name('devs_get_manajemen_barang');

    // BARANG API ROUTING

    Route::put('/devs/api/barang/create', [BarangController::class, 'create'])->middleware('auth', 'admin')->name('devs_api_create_barang');
    Route::put('/devs/api/barang/{id}', [BarangController::class, 'update_barang_info'])->middleware('auth', 'admin')->name('devs_api_update_barang');
    Route::get('/devs/api/barang/{id}', [BarangController::class, 'get_barang'])->middleware('auth', 'admin')->name('devs_api_get_barang');
    Route::get('/devs/api/barang', [BarangController::class, 'get_all_barang'])->middleware('auth', 'admin')->name('devs_api_get_all_barang');
    Route::delete('/devs/api/barang/{id}', [BarangController::class, 'destroy'])->middleware('auth', 'admin')->name('devs_post_destroy_barang');

    // EXPORT || IMPORT
    Route::get('/devs/export_stok', [ImportExportController::class, 'ExportStok'])->name('devs_export_stok');
    Route::post('/devs/import_stok', [ImportExportController::class, 'ImportStok'])->name('devs_import_stok');
    
/*
| 
| END BARANG ROUTING
| 
*/



/*
| 
| BEGIN STOK ROUTING
| 
*/

Route::get('/devs/tambah_stok',[StokController::class, 'index'])->middleware('auth', 'admin')->name('devs_get_tambah_stok');
Route::get('/devs/aliran_stok', function () {
    return view('pages.aliran-stok');
})->name('devs_get_aliran_stok');
Route::get('/devs/api/aliran_stok/{start}/{end}',[StokController::class, 'api_get_historiStok'])->middleware('auth', 'admin')->name('devs_api_get_aliran_stok');

    // STOK API ROUTING

    Route::put('/devs/api/stok/{id}', [StokController::class, 'update_stok_info'])->middleware('auth', 'admin')->name('devs_api_update_stok');
    Route::get('/devs/api/stok/{id}', [StokController::class, 'get_stok'])->middleware('auth', 'admin')->name('devs_api_get_stok');
    Route::get('/devs/api/stok', [StokController::class, 'get_all_stok'])->middleware('auth', 'admin')->name('devs_api_get_all_stok');

/*
| 
| END STOK ROUTING
| 
*/



/*
| 
| BEGIN KASIR ROUTING
| 
*/

Route::get('/devs/kasir', [KasirController::class, 'index'])->middleware('auth', 'kasir')->name('devs_get_kasir');

    // KASIR API ROUTING
    Route::put('/devs/api/kasir/bayar', [KasirController::class, 'create_transaksi'])->name('devs_api_create_transaksi_penjualan');
    Route::put('/devs/api/kasir/{id}', [KasirController::class, 'update_kasir_info'])->middleware('auth', 'admin')->name('devs_api_update_kasir');
    Route::get('/devs/api/kasir/{id}', [KasirController::class, 'get_kasir'])->middleware('auth', 'admin')->name('devs_api_get_kasir');
    Route::get('/devs/api/kasir', [KasirController::class, 'get_all_kasir'])->middleware('auth', 'admin')->name('devs_api_get_all_kasir');

    // KASIR CREATE STRUCT
    Route::get('/devs/invoice/{id}', [InvoiceController::class, 'get_invoice_by_id'])->middleware('auth', 'kasir')->name('devs_invoice_print');
    Route::get('/devs/invoice_view', [InvoiceController::class, 'get_invoice_by_id_temp'])->middleware('auth', 'kasir')->name('devs_invoice_print_view');
/*
| 
| END KASIR ROUTING
| 
*/



/*
| 
| BEGIN DASHBOARD ROUTING
| 
*/

Route::get('/devs/api/dashboard_penjualan/{start}/{end}', [DashboardController::class, 'api_get_data_penjualan'])->middleware('auth', 'admin')->name('devs_api_get_data_penjualan');
Route::get('/devs/api/dashboard_pembelian/{start}/{end}', [DashboardController::class, 'api_get_data_pembelian'])->middleware('auth', 'admin')->name('devs_api_get_data_pembelian');

/*
| 
| END DASHBOARD ROUTING
| 
*/