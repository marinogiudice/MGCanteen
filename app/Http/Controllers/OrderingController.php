<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Session;

/**
 * The class manages the public ordering section of the app
 * 
 * @author Marino Giudice
 */

class OrderingController extends Controller
{
    //shows the public ordering view
    public function index() {
        //gets the master categories
        $categories = Category::where('parent_category', null)->orderBy('category_name','ASC')->get();
        $cart=null;
        //gets the cart from the session
        if(Session::has('cart')) {
            $cart=Session::get('cart');
        }
        return view('public.ordering', ['categories' => $categories, 'cart' => $cart]);
    }


    /**
     * The function shows the products of a category in the ordering view
     * Takes in input the request and the given category
     * returns the rdering view
     */

    public function showCategory(Request $request, Category $category) {
        $cart=null;
        if(Session::has('cart')) {
            $cart=Session::get('cart');
        }
        //gets the subcategories of the specified category
        $categories = Category::where('parent_category', $category->category_name)->get();
        //gets the products of the specified category
        $products = Product::where('product_category',$category->category_name)->get();
        return view('public.ordering',['categories' => $categories, 'products' => $products, 'cart' => $cart, 'category' => $category]);
    }

    //shows the order confirmation to the customer
    public static function showOrder(Request $request, Order $order) {
        $orderItems = $order->products()->get();
        $quantities = $order->sumQty();
        $total = $order->total;
        $request->session()->flash('order', $order);
        return view('layouts.order', ['order' => $order, 'orderItems' => $orderItems, 'quantities' => $quantities]);
    }
}
   
