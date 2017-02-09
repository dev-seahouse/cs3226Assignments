<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_t', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //e.g MC,TC,HW,KS,AC,SPE
        });

        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //e.g MC,TC,HW,KS,AC,SPE
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('component_t_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('component_t_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components_t');
        Schema::dropIfExists('components');
    }
}
