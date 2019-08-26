<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedTinyInteger('gender_preference');
            //0 : Senin | 1: Selasa | 2: Rabu | 3: Kamis | 4: Jumat | 5: Sabtu | 6: Minggu
            $table->unsignedTinyInteger('day')->default(0);
            $table->time('time');
            //Pending - 0 : requesting | Postponed - 3 : accepted wait to confirmed | Accepted - 1: approved by admin | Rejected - 2: cancelled/Stop
            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();
            //If you want to track who moderated the Model add 'moderated_by' too.
            $table->integer('moderated_by')->nullable()->unsigned();
            $table->foreign('student_id')->references('id')->on('users');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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
        Schema::dropIfExists('sessions');
    }
}
