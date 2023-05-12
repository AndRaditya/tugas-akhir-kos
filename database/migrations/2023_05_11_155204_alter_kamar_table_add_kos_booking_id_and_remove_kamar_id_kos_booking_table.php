<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKamarTableAddKosBookingIdAndRemoveKamarIdKosBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kos_bookings', function (Blueprint $table) {
            $table->dropColumn('kamar_id');
        });
        
        Schema::table('kamars', function (Blueprint $table) {
            $table->integer('kos_booking_id')->nullable()->after('number');
        });

        Schema::table('kamars', function (Blueprint $table) {
            $table->dropColumn('kamar_fasilitas_id');
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