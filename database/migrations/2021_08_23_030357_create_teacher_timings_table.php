<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_timings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaching_day_id');
            $table->foreign('teaching_day_id')->on('week_days')->references('id');
            $table->timestamp('teaching_start_time')->nullable();
            $table->timestamp('teaching_end_time')->nullable();
            $table->unsignedBigInteger('subject_teacher_assignment_id');
            $table->foreign('subject_teacher_assignment_id')->on('subject_teacher_assignments')->references('id');
            $table->float('duration')->nullable();
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
        Schema::dropIfExists('teacher_timings');
    }
}
