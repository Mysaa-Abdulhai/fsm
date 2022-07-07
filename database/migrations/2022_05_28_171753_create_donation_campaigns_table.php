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
<<<<<<< HEAD
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->longText('description');
            $table->integer('total_value');
            $table->date('maxDate')->date_format('Y-m-d');
            $table->srting('image')->nullable();
            $table->foreignId('donation_campaign_request_id')->nullable();
=======
            $table->increments('id');
            $table->foreignId('donation_campaign_request_id');
            $table->string('name');
            $table->string('description');
            $table->foreignId('user_id');
            $table->text('image');
            $table->integer('total value');
            $table->date('maxDate');
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8
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
