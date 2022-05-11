<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->BigIncrements('id_history');
            $table->unsignedBigInteger('id_lelang');
            $table->unsignedBigInteger('id_pengguna');
            $table->integer('penawaran_harga');
            $table->enum('status_pemenang', ['proses', 'menang', 'kalah']);
            
            $table->foreign('id_lelang')->references('id_lelang')->on('lelang');
            $table->foreign('id_pengguna')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
}
