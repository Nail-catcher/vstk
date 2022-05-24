<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id');
            $table->string('title');
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->foreign('state_id')->on('states')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
            $table->dropForeign(['state_id']);
        });
        Schema::dropIfExists('states');
    }
}
