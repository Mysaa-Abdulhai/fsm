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
        Schema::create('campaign__posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_campaign_id');
            $table->string('title');
            $table->longText('body');
            $table->text('photo');
            $table->string('slug');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('campaign_posts');
    }
};
