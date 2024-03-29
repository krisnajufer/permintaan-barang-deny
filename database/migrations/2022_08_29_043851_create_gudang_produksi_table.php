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
        Schema::create('gudang_produksi', function (Blueprint $table) {
            $table->char('gudang_produksi_id', 6);
            $table->primary('gudang_produksi_id');
            $table->string('slug');
            $table->char('user_id', 5)->unique();
            $table->text('alamat_gudang_produksi');
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
        Schema::dropIfExists('gudang_produksi');
    }
};
