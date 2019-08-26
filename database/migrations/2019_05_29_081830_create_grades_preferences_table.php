<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades_preferences', function (Blueprint $table) {
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('teacher_preference_id');

            $table->primary(['grade_id', 'teacher_preference_id']);
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('teacher_preference_id')->references('id')->on('teacher_preferences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades_preferences');
    }
}
