<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('rrs')->nullable();
            $table->string('range')->nullable();
            $table->string('title');
            $table->string('manufacturer_code')->nullable();
            $table->string('serial_number');
            $table->string('barcode')->nullable();
            $table->string('barcode_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('inventory_user', function (Blueprint $table) {
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('installed_at')->nullable();
            $table->timestamps();
        });
        Schema::create('inventory_station', function (Blueprint $table) {
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('station_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('inventory_user');
        Schema::dropIfExists('inventory_station');
        Schema::dropIfExists('inventories');
    }
}
