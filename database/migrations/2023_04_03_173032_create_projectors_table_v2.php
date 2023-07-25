<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->string('serial_number')->nullable();
            $table->string('service_tag')->nullable();
            $table->string('inventory_code')->nullable();
            $table->date('purchased')->nullable();
            $table->string('accessory')->nullable();
            $table->text('observations')->nullable();
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projectors');
    }
};
