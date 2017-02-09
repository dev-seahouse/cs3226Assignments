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
            $table->string('name'); //e.g MC,TC,HW,KS,AC,SPE
            $table->timestamps();

            // $table -> foreign('score_id')
            //         -> references('id')->on('scores');
            //         -> onUpdate('cascade')
            //         -> onDelete('cascade');

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
