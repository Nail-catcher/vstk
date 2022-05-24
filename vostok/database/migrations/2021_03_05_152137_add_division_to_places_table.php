<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDivisionToPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->foreignId('division_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            });
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('state_id')->on('states')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('region_id')->on('regions')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('city_id')->on('cities')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropConstrainedForeignId('division_id');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);
        });
    }
}
