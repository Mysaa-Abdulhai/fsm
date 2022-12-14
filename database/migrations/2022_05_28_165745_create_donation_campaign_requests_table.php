<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *  Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_campaign_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->longText('description');
            $table->string('image');
            $table->integer('total_value');
            $table->integer('end_at');
            $table->boolean('seenAndAccept')->default(false);
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
        Schema::dropIfExists('donation_campaign_requests');
    }
};
