<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivateOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadlines', function(Blueprint $table){
            $table->boolean('isPrivate')->default(false);
        });
        Schema::table('activities', function(Blueprint $table){
            $table->boolean('isPrivate')->default(false);
        });
        Schema::table('subjects', function(Blueprint $table){
            $table->boolean('isPrivate')->default(false);
        });
        Schema::table('users', function(Blueprint $table){
            $table->boolean('isPrivate')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadlines', function(Blueprint $table){
            $table->dropColumn('isPrivate');
        });
        Schema::table('activities', function(Blueprint $table){
            $table->dropColumn('isPrivate');
        });
        Schema::table('subjects', function(Blueprint $table){
            $table->dropColumn('isPrivate');
        });
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('isPrivate');
        });
    }
}
