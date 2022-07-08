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
<<<<<<<< HEAD:database/migrations/2022_07_02_101034_create_posts_table.php
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body');
            $table->string('photo')->nullable();
========
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('role_id');
>>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8:database/migrations/2022_07_02_182940_create_user_roles_table.php
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
<<<<<<<< HEAD:database/migrations/2022_07_02_101034_create_posts_table.php
        Schema::dropIfExists('posts');
========
        Schema::dropIfExists('user_roles');
>>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8:database/migrations/2022_07_02_182940_create_user_roles_table.php
    }
};
