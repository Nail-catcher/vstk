<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartingStocktakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('starting_stocktakings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('starting_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('stocktaking_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('serial_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('starting_stocktakings');
    }
}
