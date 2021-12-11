<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportPenjualanHelper extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_penjualan_helper', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barang');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->integer('d1')->default(0);
            $table->integer('d2')->default(0);
            $table->integer('d3')->default(0);
            $table->integer('d4')->default(0);
            $table->integer('d5')->default(0);
            $table->integer('d6')->default(0);
            $table->integer('d7')->default(0);
            $table->integer('d8')->default(0);
            $table->integer('d9')->default(0);
            $table->integer('d10')->default(0);
            $table->integer('d11')->default(0);
            $table->integer('d12')->default(0);
            $table->integer('d13')->default(0);
            $table->integer('d14')->default(0);
            $table->integer('d15')->default(0);
            $table->integer('d16')->default(0);
            $table->integer('d17')->default(0);
            $table->integer('d18')->default(0);
            $table->integer('d19')->default(0);
            $table->integer('d20')->default(0);
            $table->integer('d21')->default(0);
            $table->integer('d22')->default(0);
            $table->integer('d23')->default(0);
            $table->integer('d24')->default(0);
            $table->integer('d25')->default(0);
            $table->integer('d26')->default(0);
            $table->integer('d27')->default(0);
            $table->integer('d28')->default(0);
            $table->integer('d29')->default(0);
            $table->integer('d30')->default(0);
            $table->integer('d31')->default(0);
            $table->integer('jumlah_barang');
            $table->decimal('harga_beli', 8, 0);
            $table->decimal('pajak', 8, 4)->default(0.015);
            $table->decimal('harga_beli_terpajak', 8, 0)->default(0);
            $table->decimal('harga_jual', 8, 0);
            $table->decimal('total_pokok', 8, 0)->default(0);
            $table->decimal('total_jual', 8, 0)->default(0);
            $table->decimal('laba', 8, 0)->default(0);
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
        Schema::dropIfExists('export_penjualan_helper');
    }
}
