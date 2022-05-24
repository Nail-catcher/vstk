<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('region_id')->on('regions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->foreign('region_id')->on('regions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });
        Schema::dropIfExists('regions');
    }
}
