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
        Schema::create('permintaan_barang_gudang_produksi', function (Blueprint $table) {
            $table->char('permintaan_barang_gudang_produksi_id', 15);
            $table->primary('permintaan_barang_gudang_produksi_id');
            $table->string('slug');
            $table->char('user_id', 5);
            $table->date('tanggal_permintaan');
            $table->string('status_permintaan');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_barang_gudang_produksi');
    }
};
