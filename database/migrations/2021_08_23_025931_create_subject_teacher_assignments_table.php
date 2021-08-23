<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTeacherAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');

            $table->unsignedBigInteger('classroom_id');
            $table->foreign('classroom_id')->on('class_hierarchies')->references('id');

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->on('class_hierarchies')->references('id');

            $table->json('teacher_ids');
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
        Schema::dropIfExists('subject_teacher_assignments');
    }
}
