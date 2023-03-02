{{-- 
    The order view.
    It's used as layout since it's used in both the "public" and "private" section of the app
    to provide the order confirmation to the customer and to show the order details to the restaurant manager.
    Extends the public view
    --}}
@extends('layouts.public')
@section('content')
    <main class="min-vh-100">
        <section class="row panel shadow">
            <article class="col mt-4 pb-4">
                <h2 class="my-4">Your Order Number: {{ $order->id  }}</h2>
                <div class="row">
                    <div class="col-6">
                        <h4 class="d-none d-md-block">Guest Name: {{ capitalize($order->guest_name) }}</h4>
                        <h4 class="d d-md-none">Guest: {{ capitalize($order->guest_name) }}</h4>
                    </div>
                    <div class="col-6 d-md-none text-right">
                        <h4>Table: {{ $order->table_number ? $order->table_number : 'Unknown' }}</h4>
                    </div>
                    <div class="col-6 d-none d-md-block text-right">
                        <h4>Table Number: {{ $order->table_number ? $order->table_number : 'Unknown' }}</h4>
                    </div>
                </div>
                <div class="table-responsive" style="overflow: hidden;">
                    <table class="table table-hover table-sm table-borderless">
                        <thead class="border-bottom">
                            <th scope="col">Product Name</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                        </thead>
                        <tbody>
                        @foreach($orderItems as $item)   
                            <tr>
                                <td>{{ $item->product_name ? capitalize($item->product_name) : 'Unknown' }}</td>
                                @if($item->pivot)
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{ number_format($item->pivot->total, 2). '£' }}</td>
                                @else
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->total, 2). '£' }}</td>
                                @endif
                                
                                
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="border border-top-1 border-bottom-0">
                            <tr>
                                <th class="text-right">Total</th>
                                <th>{{ $quantities }}</td>
                                <th>{{ number_format($order->order_total, 2). '£'  }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if(request()->is('admin/*'))
                <a href="/admin/orders" class="btn btn-primary">Back to Orders</a>
                @else
                <a href="/" target="_blank" class="btn btn-primary">Back to Homepage</a>
                @endif
                
            </article>
        </section>
    </main>
@endsection