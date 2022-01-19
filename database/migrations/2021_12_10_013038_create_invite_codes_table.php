<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInviteCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('accepted')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invite_codes', function (Blueprint $table) {
            //
            $table->dropForeign('invite_codes_user_id_foreign');
        });

        Schema::dropIfExists('invite_codes');
    }
}
