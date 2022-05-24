<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
        });
        Schema::create('application_status', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('status_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('old_status_id')->constrained('statuses')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('application_status');
        Schema::dropIfExists('statuses');
    }
}
