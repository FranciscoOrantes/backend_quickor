<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FirebaseTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebaseTokens', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();            
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->string('token_firebase');
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
        Schema::dropIfExists('firebaseTokens');
    }
}
