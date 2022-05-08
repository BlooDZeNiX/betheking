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
        Schema::create('stream_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voter')
            ->constrained('users');
        $table->unsignedBigInteger('streamer_voted');
        $table->foreign('streamer_voted')
            ->references('id_streamer')
            ->on('streamers');
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
        Schema::dropIfExists('stream_votes');
    }
};
