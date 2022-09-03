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
        Schema::create('pengiriman_barang_gudang_produksi', function (Blueprint $table) {
            $table->char('pengiriman_barang_gudang_produksi_id', 15);
            $table->primary('pengiriman_barang_gudang_produksi_id');
            $table->string('slug');
            $table->char('permintaan_barang_gudang_produksi_id', 15);
            $table->date('tanggal_pengiriman');
            $table->date('tanggal_penerimaan');
            $table->timestamps();

            $table->foreign('permintaan_barang_gudang_produksi_id')
                ->references('permintaan_barang_gudang_produksi_id')
                ->on('permintaan_barang_gudang_produksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman_barang_gudang_produksi');
    }
};
