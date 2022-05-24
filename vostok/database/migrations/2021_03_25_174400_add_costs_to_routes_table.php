<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostsToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->after('expenses', function (Blueprint $table) {
                $table->float('fuel_costs', '60', '8')->default(0);
                $table->float('travel_costs', '60', '8')->default(0);
                $table->float('material_costs', '60', '8')->default(0);
                $table->float('overnight_costs', '60', '8')->default(0);
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
                'fuel_costs',
                'travel_costs',
                'material_costs',
                'overnight_costs'
            ]);
        });
    }
}
