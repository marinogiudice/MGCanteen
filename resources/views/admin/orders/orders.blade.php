{{-- 
    The orders view.
    It's the index page of the orders section.
    Shows a listing of the orders present in the system.
    --}}
@extends('layouts.app')
@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
            <h2 class="mb-3 mt-4">Orders</h2>
            <div class="table-responsive">
                <table class="table table-hover table-sm table-borderless">
                    <thead class="border-bottom">
                        <th scope="col">Number</th>
                        <th scope="col" class="d-none d-md-table-cell">Table</th>
                        <th scope="col">Guest</th>
                        <th scope="col">Total</th>
                        <th scope="col" class="d-none d-md-table-cell">Placed On</th>
                        <th scope="col"></th>
                        
                    
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        {{-- dd($order->id) --}}
                        <td>{{  $order->id }}</td>
                        <td class="d-none d-md-table-cell">{{  $order->table_number ? $order->table_number : 'Unknown' }}</td>
                        <td>{{  capitalize($order->guest_name) }}</td>
                        <td>{{  $order->order_total }}</td>
                        <td class="d-none d-lg-table-cell">{{  $order->created_at }}</td>
                        <td><a class="btn btn-secondary" href="{{ '/admin/orders/'.$order->id }}">Details</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
                 @if($orders->isEmpty()) 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>No Orders To Show</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            <div class="d-flex justify-content-center">
                {!! $orders->links() !!}
            </div>
            <div class="text-left mt-3">
                <a class="btn btn-primary" href="/admin">Back</a>
            </div>
        </article>
    </section>
@endsection