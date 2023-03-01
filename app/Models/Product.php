<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The class specifies the operations for the Product Model class
 * 
 * @author Marino Giudice
 */

class Product extends Model
{
    //disables Ids as primary key
    public $incrementing = 'false';
    //specifies that the model uses product name as primary key
    protected $primaryKey = 'product_name';
    //primary key type
    protected $keyType = 'string';
    //fillables property
    protected $fillable=['product_name', 'product_category'];

    //returns the orders where this product appears
    //uses the pivot table orderProduct
    public function orders() {
        return $this->belongsToMany(Order::class,'order_product', 'product_name', 'order_id')->withTimestamps();
    }

}
