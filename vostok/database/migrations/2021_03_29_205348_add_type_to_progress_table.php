<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->after('title', function (Blueprint $table) {
                $table->foreignId('type_id')->default(1)->constrained('progress_types')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::table('progress', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });
    }
}
