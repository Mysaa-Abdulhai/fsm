<?php
use App\Models\User;
use App\Models\location;
use App\Models\photo;
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
        Schema::create('volunteer_campaign_requests',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->foreignId('location_id');
                $table->foreignId('photo_id');
                $table->string('details');
                $table->string('type');
                $table->integer('volunteer number');
                $table->string('target');
                $table->time('maxDate');
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
        Schema::dropIfExists('volunteer_campaign_requests');
    }
};
