<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('states', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('division_id')->on('divisions')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
            $table->dropForeign(['division_id']);
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::table('stations', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
        });
        Schema::dropIfExists('divisions');
    }
}
