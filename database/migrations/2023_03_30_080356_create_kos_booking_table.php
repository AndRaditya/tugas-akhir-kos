<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKosBookingTable extends Migration
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
            $table->integer('users_id')->nullable();
            $table->integer('kamar_id')->nullable();
            $table->integer('kos_bukti_transfer_id')->nullable();
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
        Schema::dropIfExists('kos_booking');
    }
}