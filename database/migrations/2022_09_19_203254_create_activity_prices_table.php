<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->integer('price')->default(0);
            $table->integer('group_price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('group_discount')->default(0);
            $table->string('currency_code', 10)->nullable();
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
        Schema::dropIfExists('activity_prices');
    }
}
