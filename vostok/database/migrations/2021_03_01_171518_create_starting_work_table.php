<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartingWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('starting_progress_work', function (Blueprint $table) {
            $table->foreignId('starting_progress_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('starting_progress_work');
    }
}
