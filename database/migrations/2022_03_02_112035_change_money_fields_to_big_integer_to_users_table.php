<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMoneyFieldsToBigIntegerToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->bigInteger('released')->change();
            $table->bigInteger('withdrawn')->change();
            $table->bigInteger('released_from_pending')->change();
            $table->bigInteger('money_added')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('big_integer_to_users', function (Blueprint $table) {
            //
        });
    }
}
