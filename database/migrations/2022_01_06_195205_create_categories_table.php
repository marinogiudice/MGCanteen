<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     * Defines the table columns name and types, primary key and foreign key
     * Sets a Recursive relationship on categories to allow the creation of subcategories
     *
     * @return void
     * @author Marino Giudice
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('category_name', 20);
            //set category_name as primary key
            $table->primary('category_name');
            $table->string('parent_category',20)->nullable();
            //set parent-category as foreign key on the table categories
            $table->foreign('parent_category')->on('categories')->references('category_name')->onDelete('set null');
            //enables the use of timestamp recording for operations executed on the table
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
