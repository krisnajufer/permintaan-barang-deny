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
        Schema::create('barang_gudang_produksi', function (Blueprint $table) {
            $table->char('barang_gudang_produksi_id', 8);
            $table->primary('barang_gudang_produksi_id');
            $table->string('slug');
            $table->char('gudang_produksi_id', 5);
            $table->string('nama_barang')->unique();
            $table->timestamps();

            $table->foreign('gudang_produksi_id')
                ->references('gudang_produksi_id')
                ->on('gudang_produksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_gudang_produksi');
    }
};
