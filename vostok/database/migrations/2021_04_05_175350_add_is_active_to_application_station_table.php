<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToApplicationStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('application_station', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('is_complete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('application_station', function (Blueprint $table) {
            $table->dropColumn(['is_active']);
        });
    }
}
