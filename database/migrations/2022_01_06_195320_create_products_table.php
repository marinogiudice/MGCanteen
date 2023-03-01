<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     * Defines column name and types primary keys and foreign keys
     *
     * @return void
     * @author Marino Giudice
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            //sets product_name as primary key.
            $table->string('product_name', 30)->primary();
            $table->string('product_description', 50)->nullable();
            $table->string('product_pic')->nullable();
            $table->string('product_category', 20)->nullable();
            //sets product_catrgory as foreign key on the categories table
            $table->foreign('product_category')->references('category_name')->on('categories')->onDelete('set null');
            $table->decimal('product_price', 5,2);
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
        Schema::dropIfExists('products');
    }
}
