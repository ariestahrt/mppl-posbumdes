<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pembelian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peg_id')->constrained('pegawai')->onDelete('restrict')->onUpdate('cascade');

            $table->string('nama_supplier');
            $table->string('status_bayar');
            $table->decimal('total_belanja', 8, 0);
            $table->decimal('total_bayar', 8, 0);
            $table->decimal('kembalian', 8, 0);

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
        Schema::dropIfExists('transaksi_pembelian');
    }
}
