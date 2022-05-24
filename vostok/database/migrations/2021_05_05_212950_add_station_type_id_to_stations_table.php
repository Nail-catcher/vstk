<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStationTypeIdToStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->foreignId('station_type_id')->after('id');
        });
        $types = \App\Models\StationType::all();
        \App\Models\Station::chunk(100, function (\Illuminate\Database\Eloquent\Collection $stations) use ($types) {
            $stations->each(function (\App\Models\Station $station) use ($types) {
                $station->stationType()->associate($types->firstWhere('title', '=', $station->base_station_type));
                $station->save();
            });
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->foreign('station_type_id')->on('station_types')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('station_type_id');
        });
        Schema::dropIfExists('station_types');
    }
}
