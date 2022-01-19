<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceUser2ToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->bigInteger('reference_user2_id')->unsigned()->nullable();

            $table->foreign('reference_user2_id', 'transactions_reference_user2_id_foreign')->on('users')->references('id')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->dropForeign('transactions_reference_user2_id_foreign');
            $table->dropColumn('reference_user2_id');
        });
    }
}
