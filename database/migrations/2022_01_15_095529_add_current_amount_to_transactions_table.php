<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentAmountToTransactionsTable extends Migration
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
            $table->double('current_amount')->default(0);
            $table->bigInteger('reference_user_id')->unsigned()->nullable();

            $table->foreign('reference_user_id','transactions_reference_user_id_foreign')->on('users')->references('id')->onUpdate('cascade');
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
            $table->dropForeign('transactions_reference_user_id_foreign');
            $table->dropColumn('current_amount');
            $table->dropColumn('reference_user_id');
        });
    }
}
