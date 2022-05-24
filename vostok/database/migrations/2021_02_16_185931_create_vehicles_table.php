<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('number');
            $table->string('title');
            $table->unsignedFloat('basic');
            $table->unsignedFloat('winter');
            $table->unsignedFloat('summer');
            $table->timestamps();
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->foreign('vehicle_id')->on('vehicles')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
        });
        Schema::dropIfExists('vehicles');
    }
}
