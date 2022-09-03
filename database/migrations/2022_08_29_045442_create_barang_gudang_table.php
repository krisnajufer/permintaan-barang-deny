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
        Schema::create('barang_gudang', function (Blueprint $table) {
            $table->char('barang_gudang_id', 14);
            $table->primary('barang_gudang_id');
            $table->string('slug');
            $table->char('gudang_id', 5);
            $table->char('barang_gudang_produksi_id');
            $table->integer('quantity_barang_gudang');
            $table->timestamps();

            $table->foreign('gudang_id')
                ->references('gudang_id')
                ->on('gudang')->onDelete('cascade');

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
        Schema::dropIfExists('barang_gudang');
    }
};
