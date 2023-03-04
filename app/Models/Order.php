<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

/**
 * 
 * The Class defines the Order Model Object 
 * 
 * @author Marino Giudice
 */


class Order extends Model
{
    //mass asssignment protection specifies which property are assignable from 
    //the user.
    
    protected $fillable = ['table_number', 'guest_name', 'order_total'];

    //returns the products of an order
    //used to present the order conformation to the user.
    public function products() {
        return $this->belongsToMany(Product::class,'order_product', 'order_id', 'product_name')->withPivot('quantity','total')->withTimeStamps();
    }

    //sums the Quantities of the products of an order
    //used to present order confirmation to the user
    public function sumQty() {
        return $this->products()->sum('quantity');
    }

    //returns the orderProducts items of the orderProduct db table
    //belonging to an order. Used to display order details in the order history 
    public function orderProducts() {
        return $this->hasMany(orderProduct::class);

    }

    //return the list of the orders ordered by the most recent
    
    public static function getOrders() {
        return Order::orderBy('created_at','desc');
    }

    //return the total quantties of the orderProduct of an order details.
    public function orderProductsQty() {     
        return $this->orderProducts()->sum('quantity');
    }
}



