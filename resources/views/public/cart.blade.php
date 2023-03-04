{{--  
    The cart view.
    It's used to show the cart to the user
    offers all the elements to let  to proceed with the order or delete
    the cart items.
    Shows Totals.
    Extends the public view.
    --}}
@extends('layouts.public')
@section('content')
    <main class="min-vh-100">
        <section class="panel shadow row">
            <article class="col mt-4">
            <h2 class="">Your Order</h2>
            @if(isset($cart) && $cart->totalQty>0)
            <div class="table-responsive">
                <table class="table table-hover table-sm table-borderless" style="overflow:hidden;">
                    <thead class="border-bottom">
                        <th scope="col">Product Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                    </thead>
                    <tbody>
                    @foreach($cart->items as $key)
                        <tr>
                            <td>{{  capitalize($key['product']) }}</td>
                            <td>{{  $key['qty'] }}</td>
                            <td>{{  number_format($key['price'], 2).' £' }}</td>
                            <td class="text-right">
                                <form method="POST" class="" action="/ordering/cart/{{ $key['product'] }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="border border-top-1 border-bottom-0">
                        <tr>
                            <th class="text-right">Total</th>
                            <th>{{ $cart->totalQty }}</td>
                            <th>{{ number_format($cart->totalPrice, 2).' £' }}</td>
                            <th></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="clearfix mt-4 pb-4">
                <a href="/ordering/order/cart/proceed"class="btn btn-dark float-right">Proceed</a>
                <a href="/ordering"class="btn btn-primary float-left">Back to Menu</a>
            </div>
        </article>
    </section>
    @else
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>Cart Empty</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    </main>
@endsection