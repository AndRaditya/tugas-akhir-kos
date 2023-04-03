<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('kos_booking_id')->nullable();
            $table->integer('kos_bukti_transfer_id')->nullable();
            $table->integer('kamar_id')->nullable();
            $table->integer('biaya_tambahan_id')->nullable();
            $table->integer('transaksi_masuk_kategori_id')->nullable();

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
        Schema::dropIfExists('transaksi_masuk');
    }
}