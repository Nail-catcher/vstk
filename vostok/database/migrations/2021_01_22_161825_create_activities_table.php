<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
        });
        Schema::create('activity_route', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->foreignId('activity_id')->default(1)->after('user_id')->constrained('activities')->cascadeOnUpdate()->cascadeOnDelete();
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
            $table->dropConstrainedForeignId('activity_id');
        });
        Schema::dropIfExists('activity_route');
        Schema::dropIfExists('activities');
    }
}
