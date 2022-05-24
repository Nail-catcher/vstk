<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id');
            $table->foreignId('area_id');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedFloat('distance', '60', '8')->nullable();
            $table->softDeletes();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
        Schema::create('application_route', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('application_route');
        Schema::dropIfExists('routes');
    }
}
