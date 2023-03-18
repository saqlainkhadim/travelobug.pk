<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->integer('basics')->default(0);
            $table->integer('description')->default(0);
            $table->integer('location')->default(0);
            $table->integer('photos')->default(0);
            $table->integer('pricing')->default(0);
            $table->integer('booking')->default(0);
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
        Schema::dropIfExists('activity_steps');
    }
}
