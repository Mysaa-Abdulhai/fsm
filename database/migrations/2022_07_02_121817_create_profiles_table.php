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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->integer('birth_date')->date_format('Y-m-d');
            $table->foreignId('user_id');
            $table->string('nationality');
            $table->foreignId('location_id');
            $table->string('study');
            $table->string('skills');
            $table->integer('phoneNumber');
            $table->boolean('leaderInFuture')->default(false);
            $table->text('image');
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
        Schema::dropIfExists('profiles');
    }
};
