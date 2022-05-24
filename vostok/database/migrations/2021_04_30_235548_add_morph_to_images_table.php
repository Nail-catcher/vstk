<?php

use App\Models\Image;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMorphToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->morphs('imageable');
            });
            $table->timestamp('attached_at')->nullable()->after('path');
        });
        Image::with('application')->whereNull('starting_progress_id')->chunk(100, function (Illuminate\Database\Eloquent\Collection $images) {
            $images->each(function (Image $image) {
                $image->imageable()->associate($image->application);
                $image->save();
            });
        });
        Image::with('progress')->whereNotNull('starting_progress_id')->chunk(100, function (Illuminate\Database\Eloquent\Collection $images) {
            $images->each(function (Image $image) {
                $image->imageable()->associate($image->progress);
                $image->save();
            });
        });
        Schema::table('images', function (Blueprint $table) {
            $table->dropConstrainedForeignId('starting_progress_id');
            $table->dropConstrainedForeignId('application_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->foreignId('application_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('starting_progress_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            });
        });
        //TODO: Finished rollback
        Schema::table('images', function (Blueprint $table) {
            $table->dropMorphs('imageable');
            $table->dropColumn(['attached_at']);
        });
    }
}
