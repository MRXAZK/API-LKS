<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailorder', function (Blueprint $table) {
            $table->increments('IdDetail');
            $table->integer('IdOrder')->unsigned();
            $table->integer('IdMenu')->unsigned();
            $table->integer('Quantity');
            $table->integer('Price');
            $table->timestamps();

            $table->foreign('IdOrder')->references('IdOrder')->on('order')->onDelete('cascade');
            $table->foreign('IdMenu')->references('IdMenu')->on('menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailorder');
    }
};
