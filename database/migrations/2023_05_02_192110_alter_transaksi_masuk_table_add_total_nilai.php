<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransaksiMasukTableAddTotalNilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->dropColumn('biaya_tambahan_id');
        });

        Schema::table('transaksi_masuks', function (Blueprint $table) {
            $table->double('total_nilai')->after('nilai')->nullable();
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