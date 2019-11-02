<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId');
            $table->string('name');
            $table->string('teacherName');
            $table->enum('status', ['studying', 'finished', 'retired']);
            $table->integer('absenceNumber');
            $table->integer('absenceMax');
            $table->timestamps();
            $table->foreign('userId')
                  ->references('username')->on('users')
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
        Schema::dropIfExists('subjects');
    }
}
