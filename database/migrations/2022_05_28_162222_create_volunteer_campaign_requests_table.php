<?php
use App\Models\User;
use App\Models\location;
use App\Enums;
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
                $table->boolean('seen')->default(false);
                $table->string('name')->unique();
                $table->text('image');
                $table->longText('details');
                $table->enum('type',['natural','human','pets','others']);
                $table->enum('study',['Primary School','Middle School','High School'
                    ,"Bachelor\'s Degree",'Master Degree','phD Degree','No Study']);
                $table->integer('volunteer_number');
                $table->decimal('longitude', 10, 8);
                $table->decimal('latitude', 10, 8);
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
        Schema::dropIfExists('volunteer_campaign_requests');
    }
};
