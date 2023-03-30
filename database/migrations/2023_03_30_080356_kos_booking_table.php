<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KosBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kos_booking', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255);
            $table->dateTime('date');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('total_bulan');
            $table->integer('total_kamar');
            $table->string('status', 50);
            $table->float('total_price');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}