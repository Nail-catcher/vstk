<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id');
            $table->foreignId('area_id');
            $table->foreignId('state_id');
            $table->foreignId('region_id');
            $table->foreignId('city_id');
            $table->string('bts_id');
            $table->string('rac')->nullable();
            $table->text('title')->nullable();
            $table->point('location', '4326');
            $table->text('base_station_type')->nullable();
            $table->text('type_steel_structure')->nullable();
            $table->text('supply')->nullable();
            $table->unsignedDecimal('distance')->default(0);
            $table->string('prop_height')->nullable();
            $table->text('prop_type')->nullable();
            $table->unsignedDecimal('antenna_suspension_height_a')->default(0);
            $table->unsignedDecimal('antenna_suspension_height_b')->default(0);
            $table->unsignedDecimal('antenna_suspension_height_c')->default(0);
            $table->unsignedDecimal('antenna_azimuths_tilt_angle_a')->default(0);
            $table->unsignedDecimal('antenna_azimuths_tilt_angle_b')->default(0);
            $table->unsignedDecimal('antenna_azimuths_tilt_angle_c')->default(0);
            $table->text('equipment_installation_location')->nullable();
            $table->text('antenna_installation_location')->nullable();
            $table->text('guaranteed_power')->nullable();
            $table->text('stand_type')->nullable();
            $table->text('rectifier_units_type')->nullable();
            $table->unsignedInteger('number_rectifier_units')->default(0);
            $table->unsignedInteger('battery_capacity')->default(0);
            $table->unsignedInteger('battery_count')->default(0);
            $table->unsignedInteger('priority')->default(0);
            $table->unsignedInteger('order_number')->default(0);
            $table->unsignedInteger('order_additional')->default(0);
            $table->text('subcon')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
