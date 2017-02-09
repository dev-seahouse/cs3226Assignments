<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('score');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('component_id');
            $table->unsignedInteger('score_index');
            $table->timestamps();

            $table -> foreign('student_id')
                   -> references('id')
                   -> on('students')
                   -> onUpdate('cascade')
                   -> onDelete('cascade');

            $table -> foreign('component_id')
                    -> references('id')
                    -> on('components')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
