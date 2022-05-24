<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id');
            $table->string('title');
            $table->point('location', '4326');
            $table->string('address')->nullable();
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->foreign('area_id')->on('areas')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->foreign('area_id')->on('areas')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->foreign('area_id')->on('areas')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
        });
        Schema::dropIfExists('areas');
    }
}
