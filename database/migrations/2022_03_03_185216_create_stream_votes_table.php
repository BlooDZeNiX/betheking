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
            $table->foreignIdFor(\App\models\User::class, 'voter');
            $table->foreignIdFor(\App\models\Streamers::class, 'streamer_voted');
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
