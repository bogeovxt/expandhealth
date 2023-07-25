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
        Schema::table('employees', function (Blueprint $table) {

            $table->string('email')->nullable()->after('lname');
            $table->string('email2')->nullable()->after('email');
            $table->string('phone')->nullable()->after('email2');
            $table->string('phone2')->nullable()->after('phone');
            $table->string('cnp')->nullable()->after('phone2');
            $table->date('birthday')->nullable()->after('cnp');
            $table->date('employment_at')->nullable()->after('birthday');
            $table->string('nextup_id')->nullable()->after('employment_at');
            $table->unsignedInteger('colorful_id')->nullable()->after('nextup_id');
        });
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
