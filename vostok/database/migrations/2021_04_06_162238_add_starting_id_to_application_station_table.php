<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartingIdToApplicationStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('application_station', function (Blueprint $table) {
            $table->foreignId('starting_id')->nullable()->after('station_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**ApplicationProgressTableSeeder
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('application_station', function (Blueprint $table) {
            $table->dropConstrainedForeignId('starting_id');
        });
    }
}
