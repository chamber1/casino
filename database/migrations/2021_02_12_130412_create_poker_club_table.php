<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokerClubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poker_club', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon',250)->nullable();
            $table->string('warranty')->nullable();
            $table->string('by_in')->nullable();
            $table->string('stack')->nullable();
            $table->string('levels')->nullable();
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
        Schema::dropIfExists('poker_club');
    }
}
