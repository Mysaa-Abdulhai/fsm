<?php

use App\Models\donation_campaign_request;
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
        Schema::create('donation_campaigns', function (Blueprint $table) {

            $table->id();
            $table->foreignId('donation_campaign_request_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->foreignId('user_id');
            $table->text('image');
            $table->integer('total value');
            $table->date('maxDate');
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
        Schema::dropIfExists('donation_campaigns');
    }
};
