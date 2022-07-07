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
        Schema::create('archived_compaigns', function (Blueprint $table) {
<<<<<<< HEAD
            $table->increments('id');
            $table->string('name_campaign');
=======
            $table->id();
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8
            $table->foreignId('volunteer_campaign_request_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('archived__compaigns');
    }
};
