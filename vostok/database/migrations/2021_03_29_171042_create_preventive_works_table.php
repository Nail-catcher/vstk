<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreventiveWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('preventive_works', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('modelable');
            $table->text('value')->nullable();
            $table->text('deviation')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('starting_progresses', function (Blueprint $table) {
            $table->after('progress_id', function (Blueprint $table) {
                $table->nullableMorphs('typeable');
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
        Schema::table('starting_progresses', function (Blueprint $table) {
            $table->dropMorphs('typeable');
        });
        Schema::dropIfExists('preventive_works');
    }
}
