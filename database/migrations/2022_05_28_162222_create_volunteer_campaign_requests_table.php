<?php
use App\Models\User;
use App\Models\location;
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
                $table->string('name');
                $table->text('image');
                $table->string('details');
                $table->string('type');
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
