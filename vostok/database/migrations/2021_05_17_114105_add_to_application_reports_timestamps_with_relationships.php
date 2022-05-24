<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToApplicationReportsTimestampsWithRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('application_reports', function (Blueprint $table) {
            $table->foreignId('engineer_id')->after('application_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
        Schema::create('application_report_work', function (Blueprint $table) {
            $table->foreignId('application_report_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::table('application_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('engineer_id');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
        Schema::dropIfExists('application_report_work');
    }
}
