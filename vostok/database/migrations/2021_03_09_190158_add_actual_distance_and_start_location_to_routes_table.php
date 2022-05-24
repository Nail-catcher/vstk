<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualDistanceAndStartLocationToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->after('distance', function (Blueprint $table) {
                $table->unsignedFloat('actual_distance', '60', '8')->nullable();
                $table->point('start_location', '4326')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn([
                'actual_distance',
                'start_location'
            ]);
        });
    }
}
