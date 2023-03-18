<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVerifiedColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ALTER TABLE users ADD is_verified tinyint(1) NULL AFTER status;
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('verified_at')->nullable()->after('status');
            $table->boolean('is_verified')->nullable()->after('status');
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
            $table->dropColumn('verified_at');
            $table->dropColumn('is_verified');
        });
    }
}
