<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKamarTrsMasukTableNamaPenyewaAndNomorKamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kamars', function (Blueprint $table) {
            $table->string('nama_penyewa')->nullable()->after('harga');
        });

        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->integer('nomor_kamar')->nullable()->after('nilai');
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