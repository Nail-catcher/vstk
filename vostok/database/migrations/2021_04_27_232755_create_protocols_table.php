<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('starting_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('battery_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('type');
            $table->string('serial_number');
            $table->float('rated_capacity', 60, 8);
            $table->float('rated_voltage', 60, 8);
            $table->float('rated_number', 60, 8);
            $table->float('capacity', 60, 8);
            $table->float('allowable_capacity', 60, 8);
            $table->float('discharge_time_0', 60, 8);
            $table->float('discharge_time_30', 60, 8);
            $table->float('discharge_time_60', 60, 8);
            $table->float('discharge_time_90', 60, 8);
            $table->float('discharge_time_120', 60, 8);
            $table->float('discharge_time_150', 60, 8);
            $table->float('discharge_time_180', 60, 8);
            $table->float('discharge_time_210', 60, 8);
            $table->float('discharge_time_240', 60, 8);
            $table->float('discharge_time_270', 60, 8);
            $table->float('discharge_time_300', 60, 8);
            $table->float('discharge_time_330', 60, 8);
            $table->float('discharge_time_360', 60, 8);
            $table->float('discharge_time_390', 60, 8);
            $table->float('discharge_time_420', 60, 8);
            $table->float('discharge_time_450', 60, 8);
            $table->float('discharge_time_480', 60, 8);
            $table->text('device');
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
        Schema::dropIfExists('protocols');
    }
}
