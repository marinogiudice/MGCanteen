{{-- 
    The order details view.
    extends the app view.
    includes the order layout to show the order details of a specific order.
    --}}
@extends('layouts.app')
@section('content')
@include('layouts.order', ['order' => $order, 'orderItems' => $orderItems])
@endsection