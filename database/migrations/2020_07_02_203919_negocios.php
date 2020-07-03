<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Negocios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $table = "negocios";
    public function up()
    {
        Schema::create('negocios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('rfc'); 
            $table->integer('gerente_id')->unsigned();            
            $table->foreign('gerente_id')->references('id')->on('gerentes'); 
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
        Schema::dropIfExists('negocios');
    }
}
