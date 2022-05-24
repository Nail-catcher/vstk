<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('progress_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
        });
        Schema::table('startings', function (Blueprint $table) {
            $table->foreignId('type_id')->default(1)->after('application_id')->constrained('progress_types')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('startings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });
        Schema::dropIfExists('progress_types');
    }
}
