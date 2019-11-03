<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMaxAbsenceOnSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function(Blueprint $table){
            $table->dropColumn('absenceMax');
        });

        Schema::table('subjects', function(Blueprint $table){
            $table->integer('absenceMax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function(Blueprint $table){
            $table->integer('absenceMax', 11)->nullable(false)->change();
        });
    }
}
