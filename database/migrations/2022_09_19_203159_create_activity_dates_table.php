<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->enum('status', ['Available', 'Not available'])->default('Available');
            $table->integer('price')->default(0);
            $table->tinyInteger('min_stay')->default(0);
            $table->integer('min_day')->default(0);
            $table->date('date')->nullable();
            $table->string('color', 150)->nullable();
            $table->enum('type', ['calendar', 'normal'])->default('normal');
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
        Schema::dropIfExists('activity_dates');
    }
}
