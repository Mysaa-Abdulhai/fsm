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
<<<<<<< HEAD:database/migrations/2022_06_27_092636_create_campaign_posts_table.php
        Schema::create('campaign_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');  //leader
=======
        Schema::create('public_posts', function (Blueprint $table) {
            $table->id();
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8:database/migrations/2022_07_02_143015_create_public_posts_table.php
            $table->string('title');
            $table->longText('body');
            $table->text('photo');
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
        Schema::dropIfExists('public_posts');
    }
};
