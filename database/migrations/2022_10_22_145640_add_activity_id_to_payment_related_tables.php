<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityIdToPaymentRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->string('property_id')->nullable()->change();
            $table->string('activity_id')->nullable()->after('property_id');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->string('property_id')->nullable()->change();
            $table->string('activity_id')->nullable()->after('property_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
    }
}
