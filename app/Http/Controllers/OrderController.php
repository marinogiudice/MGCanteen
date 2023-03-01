<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\OrderingController;
use Session;

/**
 * The class manages the operation on the order model class
 * 
 * @author Marino Giudice
 */

class OrderController extends Controller
{
    //return the orders view
    public function index() {
        $paginatedOrders=Order::getOrders()->paginate(10);
        return view('admin.orders.orders', ['orders' => $paginatedOrders]);
    }

    /**
     * The function stores a new order into the db.
     * Returns the order confirmation view if the order is already been placed
     */

    public function store(Request $request) {
        //check if the order is already been placed
        if(Session::has('order')) {
            $order = Session::get('order');
            return OrderingController::showOrder($request, $order);
        }
        //validates the form input
        $request->validate([
            'table' => 'bail|required',
            'guest_name' =>'bail|required|bail|max:20|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 ]*)?$)/',
        ]);
        //checks if the cart exists and is not empty
        if(Session::has('cart') && Session::get('cart')->totalQty > 0) {
            //creates the new order object and stores it into the db
            $order = Order::create([
                'table_number'=> $request->input('table'),
                'guest_name' => $request->input('guest_name'),
                'order_total' => $request->session()->get('cart')->totalPrice
                
            ]);
            //stores the cat items in the order, populates the many to many relationship
            $cart=$request->session()->get('cart');
            foreach($cart->items as $key) {
                $order->products()->attach($key['product'],['total'=> $key['price'], 'quantity' => $key['qty']]);
            }
            //deletes the cart
            $request->session()->forget('cart');
            return OrderingController::showOrder($request, $order);
        }
    }

    //show the order details view
    public function show(Request $request, Order $order) {
        //gets the order items from the pivot table orderProduct
        $orderItems = $order->orderProducts()->get();
        //sums the quantities of the order products
        $quantities = $order->orderProductsQty();
            return view('admin.orders.orderDetails',['order' => $order, 'orderItems' => $orderItems, 'quantities' => $quantities]);
    }
}

