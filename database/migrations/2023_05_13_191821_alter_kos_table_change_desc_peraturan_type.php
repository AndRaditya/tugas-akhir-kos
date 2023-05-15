<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKosTableChangeDescPeraturanType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kos', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->dropColumn('peraturan');
        });
        
        Schema::table('kos', function (Blueprint $table) {
            $table->longText('peraturan')->after('tipe');
            $table->longText('deskripsi')->after('peraturan');
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