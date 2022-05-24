<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('title');
        });
        Schema::create('sensor_station', function (Blueprint $table) {
            $table->foreignId('sensor_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_station');
        Schema::dropIfExists('sensors');
    }
}
