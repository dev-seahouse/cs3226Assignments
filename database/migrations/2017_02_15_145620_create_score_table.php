<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreTable extends Migration
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
            $table->integer('component_id');
            $table->integer('score_index')->nullable(); // index 0 = score for week 1 // we allow this be null for the purpose of generating test data
            // we allow score to be null, in addition to is_valid,
            // so that when writing the logic to mark empty fields as xy we have some flexibility in handling it
            $table->float('score')->nullable();
            // is_valid is used to indicate there is no grading on certain weeks, eg holiday
            // admin need to update each week to explicitly indicate no grading for the way by setting is_valid to false
            // yet another way to check 'no grading for the week' , is to simply skip it,
            // e.g score_index = 1,2,4,5,7, for 1 to current weeek,if number missing -> set 'xy' using javascript, this approach make more sense,
            // because admin don't create/add a new score for student if there is no score to add for the week, so at javascript default to x.y/x.y.z if index don't exist
            // currently, the db seed is designed for checking this way: if score == null || is_valid ==false, mark_xy(component_name:return xy if mc, return xy.z if tc)
            $table->boolean('is_valid')->default(true);
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
        Schema::dropIfExists('scores');
    }
}
