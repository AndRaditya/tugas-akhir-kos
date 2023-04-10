<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransaksiMasukAndKeluarTableHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->double('nilai')->after('desc');
        });

        Schema::table('transaksi_keluars', function (Blueprint $table) {
            $table->double('nilai')->after('desc');
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