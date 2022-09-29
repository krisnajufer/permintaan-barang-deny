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
        Schema::create('detail_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->char('pengiriman_id', 15);
            $table->char('barang_gudang_produksi_id', 18);
            $table->integer('jumlah_pengiriman');
            $table->string('catatan');
            $table->timestamps();

            $table->foreign('pengiriman_id')
                ->references('pengiriman_id')
                ->on('pengiriman')->onDelete('cascade');

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
        Schema::dropIfExists('detail_pengiriman');
    }
};
