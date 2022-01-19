<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('center_name');
            $table->string('center_address');
            $table->boolean('approved')->default(false);

            $table->bigInteger('user_id')->unsigned();

            $table->foreign('user_id','center_user_id_foreign')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('center', function(Blueprint $table) {
            $table->dropForeign('center_user_id_foreign');
        });

        Schema::dropIfExists('center');
    }
}
