<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('starting_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('counter_number');
            $table->float('phase_1', 60, 8);
            $table->float('phase_2', 60, 8);
            $table->float('phase_3', 60, 8)->nullable();
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
        Schema::dropIfExists('measurements');
    }
}
