<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('producto_id')->unsigned();            
            $table->foreign('producto_id')->references('id')->on('productos'); 
            $table->integer('proveedor_id')->unsigned();            
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->integer('gerente_id')->unsigned();            
            $table->foreign('gerente_id')->references('id')->on('gerentes');
            $table->string('status');
            $table->string('status_pago');
            $table->string('fecha');
            $table->integer('num_pedido');
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
        //
    }
}