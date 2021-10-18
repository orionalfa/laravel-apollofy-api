<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalPlaysHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_plays', function (Blueprint $table) {
            $table->id();
            // ALERT : timestamp has 2h gap with real time
            $table->timestamps();
            $table->string('track_id');
            $table->string('track_owner_id');
            $table->string('track_player_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_plays_history');
    }
}
