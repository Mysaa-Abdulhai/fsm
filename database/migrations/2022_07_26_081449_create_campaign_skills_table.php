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
        Schema::create('campaign_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_campaign_id');
            $table->enum('name',['Speaks many languages','Socializer',
                'Able to handle kids','Available for long periods of time','Master Degree'
                ,'Can do tasks the requires physical abilities','Driver']);
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
        Schema::dropIfExists('campaign_skills');
    }
};
