<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deadlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId');
            $table->string('name');
            $table->date('end_date');
            $table->time('end_hour');
            $table->bigInteger('subjectId')->unsigned();
            $table->bigInteger('noteId')->unsigned()->nullable();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->timestamps();
            $table->foreign('userId')
                  ->references('username')->on('users')
                  ->onDelete('cascade');
            $table->foreign('subjectId')
                  ->references('id')->on('subjects')
                  ->onDelete('cascade');
            $table->foreign('noteId')
                  ->references('id')->on('notes')
                  ->onDelete('set null');                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deadlines');
    }
}
