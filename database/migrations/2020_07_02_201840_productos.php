<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $table = "productos";
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('presentacion');
            $table->integer('cantidad_presentacion');
            $table->integer('tamano_producto');
            $table->string('categoria');          
            $table->string('logo');
            $table->float('precio'); 
            $table->integer('marca_id')->unsigned();            
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->integer('proveedor_id')->unsigned();            
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
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
        Schema::dropIfExists('productos');
    }
}
