<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGasolineCostToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->unsignedFloat('gasoline_cost')->default(0)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('gasoline_cost');
        });
    }
}
