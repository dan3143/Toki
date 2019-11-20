<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('providerId');
            $table->string('subscriberId');
            $table->bigInteger('providerSubjectId')->unsigned();
            $table->bigInteger('subscriberSubjectId')->unsigned();
            $table->timestamps();
            $table->foreign('providerSubjectId')
                  ->references('id')->on('subjects')
                  ->onDelete('cascade'); 
            $table->foreign('subscriberSubjectId')
                  ->references('id')->on('subjects')
                  ->onDelete('cascade'); 
            $table->foreign('providerId')
                  ->references('username')->on('users')
                  ->onDelete('cascade'); 
            $table->foreign('subscriberId')
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
        Schema::dropIfExists('subscriptions');
    }
}
