<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            //0 : Female | 1: Male | 2: All
            $table->integer('gender')->nullable()->default(0);
            //0 : Senin | 1: Selasa | 2: Rabu | 3: Kamis | 4: Jumat | 5: Sabtu | 6: Minggu | 7: Insidental
            $table->string('days')->nullable()->default('7');
            //0 : 7-9 | 1: 9-11 | 2: 11-13 | 3: 13-15 | 4: 15-17 | 5: 17-19 | 6: 19-21 | 7: Insidental
            $table->string('times')->nullable()->default('7');
            $table->unsignedInteger('radius')->nullable()->default(0);
            $table->foreign('teacher_id')->references('id')->on('users');
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
        Schema::dropIfExists('teacher_preferences');
    }
}
