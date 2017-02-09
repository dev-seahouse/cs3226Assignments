<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('type_id');
            $table->integer('score_id');
            $table->timestamps();

            $table -> foreign('student_id')
                   -> references('id')
                   -> onUpdate('cascade')
                   -> onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign('components_student_id_foreign');
        Schema::dropIfExists('components');

    }
}
