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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('rol')->default('user');
            $table->integer('gold')->default(0);
            $table->string('favorite_streamer')->default('');
            $table->string('favorite_game')->default('');
            $table->rememberToken();
            $table->string('imageUrl')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->datetime('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
