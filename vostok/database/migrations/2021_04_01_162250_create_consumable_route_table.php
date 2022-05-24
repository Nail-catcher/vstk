<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('consumable_route', function (Blueprint $table) {
            $table->foreignId('consumable_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('consumable_route');
    }
}
