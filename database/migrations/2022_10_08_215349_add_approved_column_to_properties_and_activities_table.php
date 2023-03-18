<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedColumnToPropertiesAndActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('approved')->after('recomended')->default(false);
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->boolean('approved')->after('recomended')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
