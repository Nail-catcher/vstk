<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('closed_at');
            $table->after('id', function (Blueprint $table) {
                $table->foreignId('engineer_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            });
            $table->after('distance', function (Blueprint $table) {
                $table->foreignId('vehicle_id')->nullable();
                $table->timestamp('started_at')->nullable();
                $table->timestamp('deadline_at')->nullable();
            });
        });
        Schema::create('route_user', function (Blueprint $table) {
            $table->foreignId('route_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::create('route_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('route_closures');
        Schema::dropIfExists('route_user');
        Schema::table('routes', function (Blueprint $table) {
            $table->timestamp('closed_at')->nullable()->after('deleted_at');
            $table->dropConstrainedForeignId('engineer_id');
            $table->dropColumn([
                'vehicle_id',
                'deadline_at',
                'started_at',
            ]);
        });
    }
}
