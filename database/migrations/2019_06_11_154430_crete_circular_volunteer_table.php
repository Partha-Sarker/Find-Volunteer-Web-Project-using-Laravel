<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteCircularVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circular_volunteer', function (Blueprint $table) {
            $table->bigInteger('circular_id')->unsigned();
            $table->foreign('circular_id')->references('id')->on('circulars')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circular_volunteer');
    }
}
