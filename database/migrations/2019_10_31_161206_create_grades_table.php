<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId');
            $table->bigInteger('subjectId')->unsigned();
            $table->double('value');
            $table->double('percentage');
            $table->timestamps();
            $table->foreign('userId')
                  ->references('username')->on('users')
                  ->onDelete('cascade');
            $table->foreign('subjectId')
                  ->references('id')->on('subjects')
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
        Schema::dropIfExists('grades');
    }
}