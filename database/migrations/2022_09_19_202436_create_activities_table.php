<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('url_name', 100)->nullable();
            $table->integer('host_id');
            $table->integer('activity_type')->default(0);
            $table->string('amenities')->nullable();
            $table->enum('booking_type', ['instant', 'request'])->default('request');
            $table->string('cancellation', 50)->default('Flexible');
            $table->enum('status', ['Unlisted', 'Listed'])->default('Unlisted');
            $table->tinyInteger('recomended')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
