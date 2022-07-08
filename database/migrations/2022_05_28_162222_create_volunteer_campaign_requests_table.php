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
<<<<<<< HEAD
                $table->foreignId('user_id');   
                $table->string('name');
                $table->string('type');
                $table->string('details');
                $table->string('target');
                $table->time('maxDate');
                $table->foreignId('location_id');
                $table->foreignId('photo_id');
                $table->integer('volunteer_number');
=======
                $table->foreignId('user_id');
                $table->foreignId('location_id');
                $table->text('image');
                $table->string('details');
                $table->string('type');
                $table->integer('volunteer_number');
                $table->string('target');
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
        Schema::dropIfExists('volunteer_campaign_requests');
    }
};
