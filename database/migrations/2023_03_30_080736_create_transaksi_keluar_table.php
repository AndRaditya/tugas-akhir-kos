<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_keluar', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_keluar_kategori_id')->nullable();
            $table->string('no', 255);
            $table->dateTime('tanggal');
            $table->string('desc', 255);
            $table->float('nilai');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_keluar');
    }
}