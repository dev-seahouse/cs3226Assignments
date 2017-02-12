<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Each student have a set of components, each component has a type, new type is possible
class CreateComponentsTable extends Migration
{
    /**
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('component_t_id');
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('component_t_id')
                ->references('id')
                ->on('component_t')
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
        Schema::table('components', function (Blueprint $table) {
            $table->dropForeign('components_component_t_id_foreign');
        });

        Schema::table('components', function (Blueprint $table) {
            $table->dropForeign('components_student_id_foreign');
        });

        Schema::dropIfExists('components');
    }
}
