<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('address');
            $table->point('location', '4326');
            $table->timestamps();
        });
        Schema::create('place_route', function (Blueprint $table) {
            $table->foreignId('place_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('place_route');
        Schema::dropIfExists('places');
    }
}
