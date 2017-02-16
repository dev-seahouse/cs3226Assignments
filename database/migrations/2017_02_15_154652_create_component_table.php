<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // each student have 6 components
        // note that AC component is in fact populated from records table.
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('component_sum')->nullable();
            $table->unsignedInteger('student_id');
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
        Schema::dropIfExists('components');
    }
}
