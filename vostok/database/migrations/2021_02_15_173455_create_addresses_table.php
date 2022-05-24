<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('division_id');
            $table->foreignId('state_id');
            $table->foreignId('region_id');
            $table->foreignId('city_id');
            $table->text('address');
            $table->integer('mci')->nullable();
            $table->unsignedFloat('cost', '60', '8')->nullable();
            $table->point('location', '4326');
            $table->timestamps();
        });
        Schema::create('address_route', function (Blueprint $table) {
            $table->foreignId('address_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('address_route');
        Schema::dropIfExists('addresses');
    }
}
