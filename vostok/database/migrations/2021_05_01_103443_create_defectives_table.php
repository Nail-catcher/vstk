<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('defectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('starting_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->string('serial_number');
            $table->string('inventory_number');
            $table->unsignedInteger('quantity');
            $table->text('comment');
            $table->string('barcode')->nullable();
            $table->string('barcode_type')->nullable();
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
        Schema::dropIfExists('defectives');
    }
}
