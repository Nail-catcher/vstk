<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocktakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('stocktakings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
        });
        Schema::create('station_type_stocktaking', function (Blueprint $table) {
            $table->foreignId('station_type_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('stocktaking_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('station_type_stocktaking');
        Schema::dropIfExists('stocktakings');
    }
}
