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
        Schema::create('detail_pengiriman_barang_gudang_produksi', function (Blueprint $table) {
            $table->id();
            $table->char('pengiriman_barang_gudang_produksi_id', 15);
            $table->char('barang_gudang_produksi_id', 8);
            $table->integer('jumlah_dikirim');
            $table->string('catatan_tambahan');
            $table->timestamps();

            $table->foreign('pengiriman_barang_gudang_produksi_id')
                ->references('pengiriman_barang_gudang_produksi_id')
                ->on('pengiriman_barang_gudang_produksi')->onDelete('cascade');

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
        Schema::dropIfExists('detail_pengiriman_barang_gudang_produksi');
    }
};
