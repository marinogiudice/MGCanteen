<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * Defines column name and types primary keys and foreign keys
     * for the orders Database table.
     * 
     * @return void
     * 
     * @author Marino Giudice
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            //define and sets the order id as primary key. 
            $table->id();
            $table->integer('table_number')->nullable();;
            //defines table number as foreign key on the tables db table. 
            $table->foreign('table_number')->references('table_number')->on('tables')->onDelete('set null')->onUpdate('cascade');
            //Name of the person who order
            $table->string('guest_name');
            //order total
            $table->decimal('order_total', 5,2);
            //enable timestamp record of the operation performed on the order table.
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
        Schema::dropIfExists('orders');
    }
}
