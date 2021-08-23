<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name_en', 100);
            $table->string('middle_name_en', 100);
            $table->string('last_name_en', 100);
            $table->string('email')->nullable();
            $table->string('mobile_no', 10)->nullable();

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->on('federal_hierarchies')->references('id');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->on('federal_hierarchies')->references('id');

            $table->unsignedBigInteger('vdc_mun_id')->nullable();
            $table->foreign('vdc_mun_id')->on('federal_hierarchies')->references('id');
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
        Schema::dropIfExists('students');
    }
}
