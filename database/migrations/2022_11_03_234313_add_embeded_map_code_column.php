<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmbededMapCodeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->text('embeded_map')->nullable()->after('approved');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->text('embeded_map')->nullable()->after('approved');
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
            $table->dropColumn('embeded_map');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('embeded_map');
        });
    }
}
