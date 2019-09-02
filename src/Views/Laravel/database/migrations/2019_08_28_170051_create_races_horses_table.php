<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacesHorsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races_horses', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('race_id')->index();
            $table->bigInteger('horse_id')->index();
            $table->timestamps();

            $table->unique(['race_id', 'horse_id']);

            $table->foreign('race_id')->references('id')->on('races');
            $table->foreign('horse_id')->references('id')->on('horses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('races_horses');
    }
}
