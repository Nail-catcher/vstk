<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::dropIfExists('application_progress');
        Schema::dropIfExists('application_inventory');
        Schema::create('startings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
        Schema::create('starting_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('starting_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('progress_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
        Schema::create('inventory_starting_progress', function (Blueprint $table) {
            $table->foreignId('starting_progress_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::table('images', function (Blueprint $table) {
            $table->foreignId('starting_progress_id')->nullable()->after('application_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('starting_id')->nullable()->after('status_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('starting_id');
        });
        Schema::table('images', function (Blueprint $table) {
            $table->dropConstrainedForeignId('starting_progress_id');
        });
        Schema::create('application_inventory', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('application_progress', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('progress_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('inventory_starting_progress');
        Schema::dropIfExists('starting_progresses');
        Schema::dropIfExists('startings');
    }
}
