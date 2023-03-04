<?php

namespace App\Models;

use App\Models\Product;

/**
 * The Class implements the cart functionalities
 * uses the session assign to each products' group quantitties
 * and total price.
 * Stores total quantities and total price
 * 
 */

class Cart
{
    public $items=null;
    public $totalPrice = 0;
    public $totalQty = 0;

    //constructor
    public function __construct($oldCart) {
        if($oldCart) {
            $this->items = $oldCart->items;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalQty = $oldCart->totalQty;

        }
    }

    //the function adds a product to the cart
    public function add($product) {
        //each product will belong to a group of cartItem
        $cartItem = ['qty' => 0, 'price' => $product->product_price, 'product' => $product->product_name];
        if($this->items) {
            if(array_key_exists($product->product_name, $this->items)) {
                $cartItem = $this->items[$product->product_name];
            }
        }
        //increments quantitites for the group
        $cartItem['qty']++;
        //increment price for the group
        $cartItem['price'] = $product->product_price * $cartItem['qty'];
        $this->items[$product->product_name] = $cartItem;
        //increments total quantities
        $this->totalQty++;
        //increments total price
        $this->totalPrice += $product->product_price;
    }      
}
