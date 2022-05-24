<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('dispatcher_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('engineer_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('division_id');
            $table->foreignId('area_id');
            $table->foreignId('project_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('type_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('status_id')->default(1);
            $table->string('unid')->nullable();
            $table->string('order_unid')->nullable();
            $table->string('ticket')->nullable()->index();
            $table->string('document')->nullable()->index();
            $table->enum('priority', ['critical', 'major', 'minor'])->index();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('pickup_keys')->default(false);
            $table->text('keys_comment')->nullable();
            $table->boolean('took_keys')->default(false);
            $table->unsignedFloat('distance', '60', '8')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('deadline_at')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('application_user', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('application_inventory', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('application_station', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::create('application_work', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('application_work');
        Schema::dropIfExists('application_station');
        Schema::dropIfExists('application_inventory');
        Schema::dropIfExists('application_user');
        Schema::dropIfExists('applications');
    }
}
