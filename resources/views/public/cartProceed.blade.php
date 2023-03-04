{{-- 
    cart proceed view.
    Extends the public view.
    Let the user to select the table where he is sitting and to
    input the guest name.
    Let the user to confirm the order.
    Includes the tables_select layout to show the tables list to the user.
    --}}
@extends('layouts.public')
@section('content')
<main class=" min-vh-100">
    <section class="row panel shadow">
        <article class="col mt-4">
            <h2 class="my-4">Your Details</h2>
            <form action="/ordering/order/confirm" method="post">
                @csrf
                <div class="form-row">
                    <div class="col form-group">
                        @error('table')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                        @include('layouts.tables_select',['tables' => $tables])
                    </div>
                </div>
                </div>
                <div class="form-row">
                    <div class="col form-group">
                        @error('guest_name')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                        <label for="guest_name">Your Name</label>
                        <input type="text" class="form-control" name="guest_name" placeholder="Your Name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col form-group text-right">  
                        <button class="btn btn-dark d-inline" type="submit" name=place_order>Place Order</button>
                    </div>
                </div>
            </form>
        </article>
    </section>
</main>
@endsection