<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->after('city_id', function (Blueprint $table) {
                $table->foreignId('project_id')->default(1)->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            });
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stations', function (Blueprint $table) {
           $table->dropConstrainedForeignId('project_id');
        });
    }
}
