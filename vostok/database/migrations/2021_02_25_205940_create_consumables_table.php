<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('unit_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedFloat('spm')->nullable();
            $table->unsignedFloat('atr')->nullable();
            $table->unsignedFloat('cost')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('consumables');
    }
}
