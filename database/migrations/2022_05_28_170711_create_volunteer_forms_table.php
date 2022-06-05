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
        Schema::create('volunteer_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->integer('age');
            $table->string('nationality');
            $table->foreignId('location_id');
            $table->string('study');
            $table->string('skills');
            $table->integer('phoneNumber');
            $table->foreignId('photo_id');
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
        Schema::dropIfExists('volunteer_forms');
    }
};
