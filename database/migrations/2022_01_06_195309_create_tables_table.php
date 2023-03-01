<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     * Defines the table columns name and types, primary key and foreign key
     * @return void
     * 
     * @author Marino Giudice
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->integer('table_number');
            //sets table_number as primary key.
            $table->primary('table_number');
            //enables the use of timestamp recording for operations executed on the table
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
        Schema::dropIfExists('tables');
    }
}
