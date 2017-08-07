<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function(Blueprint $table){
          $table->increments('id');
          $table->string('kode_transaction');
          $table->string('kode_menu');
          $table->integer('qty');
          $table->double('price');
          $table->integer('created_by')->unsigned();
          $table->integer('updated_by')->unsigned();
          $table->timestamps();

          $table->foreign('kode_menu')->references('kode_menu')->on('menu');
          $table->foreign('created_by')->references('id')->on('users');
          $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction');
    }
}
