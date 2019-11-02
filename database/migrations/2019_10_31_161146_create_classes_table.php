<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId');
            $table->string('name');
            $table->json('days');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->string('place');
            $table->bigInteger('subjectId')->unsigned();
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
        Schema::dropIfExists('classes');
    }
}
