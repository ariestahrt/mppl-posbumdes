<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sto_id')->constrained('stok_produk')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('tra_id')->constrained('transaksi_pembelian')->onDelete('restrict')->onUpdate('cascade');

            $table->decimal('kuantitas', 8, 0);
            $table->decimal('harga_total_awal', 8, 0);
            $table->float('diskon', 10, 0)->nullable();
            $table->float('ppn', 10, 0)->nullable();
            $table->decimal('harga_total_akhir', 8, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi_sales');
    }
}
