<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKamarSpesifikasiTableRenameName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kamar_spesifikasis', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('kamar_spesifikasis', function (Blueprint $table) {
            $table->string('desc', 255)->after('jenis');
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
