<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail', function(Blueprint $table){
          $table->string('kode_transaction');
          $table->primary('kode_transaction');
          $table->double('total_price');
          $table->double('customer_cash');
          $table->double('customer_change');
          $table->double('ppn');
          $table->integer('created_by')->unsigned();
          $table->integer('updated_by')->unsigned();
          $table->timestamps();

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
        Schema::drop('transaction_detail');
    }
}
