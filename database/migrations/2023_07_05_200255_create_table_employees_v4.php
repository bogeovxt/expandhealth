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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('cnp')->nullable();
            $table->string('location')->nullable();
            $table->date('birthday')->nullable();
            $table->date('employment_at')->nullable();
            $table->string('nextup_id')->nullable();
            $table->unsignedInteger('colorful_id')->nullable();
            $table->unsignedInteger('division_id');
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
            // $table->foreign('division_id')->references('id')->on('divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
