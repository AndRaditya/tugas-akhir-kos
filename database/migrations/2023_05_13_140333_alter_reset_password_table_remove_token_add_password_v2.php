<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResetPasswordTableRemoveTokenAddPasswordV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reset_passwords', function (Blueprint $table) {
            $table->dropColumn('token');
        });
        
        Schema::table('reset_passwords', function (Blueprint $table) {
            $table->string('password')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('password_resets');
    }
}