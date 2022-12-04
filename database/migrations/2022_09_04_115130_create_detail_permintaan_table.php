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
        Schema::create('detail_permintaan', function (Blueprint $table) {
            $table->id();
            $table->char('permintaan_id', 15);
            $table->char('barang_gudang_produksi_id', 8);
            $table->integer('jumlah_permintaan');
            $table->timestamps();

            $table->foreign('permintaan_id')
                ->references('permintaan_id')
                ->on('permintaan')->onDelete('cascade');

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
        Schema::dropIfExists('detail_permintaan');
    }
};
