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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->char('pengiriman_id', 15);
            $table->primary('pengiriman_id');
            $table->string('slug');
            $table->char('permintaan_id', 15);
            $table->date('tanggal_pengiriman');
            $table->date('tanggal_penerimaan');
            $table->timestamps();

            $table->foreign('permintaan_id')
                ->references('permintaan_id')
                ->on('permintaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
};
