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
        // Schema::table('inventories', function (Blueprint $table) {
        //     // $table->foreignIdFor(Phone::class);
        //     $table->foreignId('phone_id');

        //     // $table->unsignedBigInteger('phone_id');
        //     $table->foreign('phone_id')->references('id')->on('phones');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
