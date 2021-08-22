<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('federal_level_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_np');
            $table->unsignedBigInteger('upper_level_type_id')->nullable();
            $table->foreign('upper_level_type_id')->on('federal_level_types')->references('id');
            $table->timestamps();
        });

        Schema::create('federal_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_np');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->on('federal_hierarchies')->references('id');
            $table->unsignedBigInteger('federal_level_type_id');
            $table->foreign('federal_level_type_id')->on('federal_level_types')->references('id');
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
        Schema::dropIfExists('federal_hierarchies');
    }
}
