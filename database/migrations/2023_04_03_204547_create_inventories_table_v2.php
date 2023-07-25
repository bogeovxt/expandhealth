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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id');

            $table->unsignedBigInteger('phone_id')->nullable();
            $table->unsignedBigInteger('laptop_id')->nullable();
            $table->unsignedBigInteger('tablet_id')->nullable();
            $table->unsignedBigInteger('projector_id')->nullable();
            $table->unsignedBigInteger('usbstick_id')->nullable();
            $table->unsignedBigInteger('desktop_id')->nullable();

            $table->date('received_at');
            $table->date('delivered_at')->nullable();
            $table->text('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('employee_id')->references('id')->on('employees');   
            
            $table->foreign('phone_id')->references('id')->on('phones');
            $table->foreign('laptop_id')->references('id')->on('laptops');
            $table->foreign('tablet_id')->references('id')->on('tablets');
            $table->foreign('projector_id')->references('id')->on('projectors');
            $table->foreign('usbstick_id')->references('id')->on('usbsticks');
            $table->foreign('desktop_id')->references('id')->on('desktops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
