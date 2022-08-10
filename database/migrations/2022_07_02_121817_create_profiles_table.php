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
            $table->foreignId('user_id');
            $table->string('name');
            $table->enum('gender',['Male','Female'])->nullable();
            $table->string('bio');
            $table->date('birth_date')->nullable();
            $table->enum('study',['Primary School','Middle School','High School'
                ,'Bachelors Degree','Master Degree','phD Degree','No Studies']);
            $table->integer('phoneNumber')->nullable();
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
