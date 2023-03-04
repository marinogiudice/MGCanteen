<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Table;
use Session;

/**
 * The class manages the operations related
 * to the cart
 * 
 * @author Marino Giudice
 * 
 */

class CartController extends Controller
{
    
    /**
     * Display the cart view.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        //gets the cart object from the session
        $cart=null;
        if(Session::has('cart')) {
            $cart=$request->session()->get('cart');
        }
        return view('public.cart',['cart' => $cart]);
    }


    /**
     * Remove an element from the cart.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, Product $product)
    {
        //gets the cart object from the session
        $cart = $request->session()->get('cart');
        //checks if the passed product is in the cart and update the cart
        if(array_key_exists($product->product_name, $cart->items)) {
            $item=$cart->items[$product->product_name];
            $cart->totalQty -= $cart->items[$product->product_name]['qty'];
            $cart->totalPrice -= $cart->items[$product->product_name]['price'];
            unset($cart->items[$product->product_name]);
        }
        //stores the updated cart in the session
        $request->session()->put('cart', $cart);
        if(count(Session::get('cart')->items) === 0) {
            return redirect('/ordering');
        }
        return redirect('/ordering/order/cart');
    }

    //shows the cart proceed view    

    public function proceed() {
        $cart=null;
        if(Session::has($cart)) {
            $cart=Session::get('cart');
        }
        //gets the tables list from the db
        $tables = Table::all();
        return view('public.cartProceed', ['tables' => $tables, 'cart' => $cart]);
    }
}
