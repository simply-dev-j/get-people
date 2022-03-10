<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityAttepmtCountAndSecurityCaseToUsersTable extends Migration
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
            $table->string('security_case')->nullable(true);
            $table->integer('security_attempt_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            if (Schema::hasColumn('users', 'security_case')) {
                $table->dropColumn('security_case');
            }

            if (Schema::hasColumn('users', 'security_attempt_count')) {
                $table->dropColumn('security_attempt_count');
            }
        });
    }
}
