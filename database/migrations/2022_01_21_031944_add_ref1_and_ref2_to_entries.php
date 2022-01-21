<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRef1AndRef2ToEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            //
            $table->bigInteger('ref1')->unsigned()->nullable(true);
            $table->bigInteger('ref2')->unsigned()->nullable(true);

            $table->foreign('ref1', 'ref1_to_user')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ref2', 'ref2_to_user')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            //
            $table->dropForeign('ref1_to_user');
            $table->dropForeign('ref2_to_user');

            $table->dropColumn('ref1');
            $table->dropColumn('ref2');
        });
    }
}
