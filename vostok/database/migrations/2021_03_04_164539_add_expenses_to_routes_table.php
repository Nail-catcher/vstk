<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpensesToRoutesTable extends Migration
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
                $table->float('expenses', '60', '8')->default(0);
                $table->float('fuels', '60', '8')->default(0);
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
                'expenses',
                'fuels'
            ]);
        });
    }
}
