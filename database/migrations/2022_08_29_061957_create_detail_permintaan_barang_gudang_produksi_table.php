<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_permintaan_barang_gudang_produksi', function (Blueprint $table) {
            $table->id();
            $table->char('permintaan_barang_gudang_produksi_id', 15);
            $table->char('barang_gudang_produksi_id', 8);
            $table->integer('jumlah_permintaan');
            $table->timestamps();

            $table->foreign('permintaan_barang_gudang_produksi_id')
                ->references('permintaan_barang_gudang_produksi_id')
                ->on('permintaan_barang_gudang_produksi')->onDelete('cascade');

            $table->foreign('barang_gudang_produksi_id')
                ->references('barang_gudang_produksi_id')
                ->on('barang_gudang_produksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_permintaan_barang_gudang_produksi');
    }
};
