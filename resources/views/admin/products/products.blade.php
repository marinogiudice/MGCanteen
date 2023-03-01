{{-- 
    Products View.
    Extends the app view.
    It's the index page of the products section.
    Shows The category filter, a button to create a new product
    A product listing.
    Includes the category_filter layout to let the user to skim the product listing result.
    --}}
@extends('layouts.app')
@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
            
    <h2 class="mb-3">{{ request()->is('admin/products*') && isset($name) ? 'Products Of '.$name: 'Products'}}</h2>
    <form method="post" action="/admin/products/filter">
        @csrf
        @error('category')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        @include('admin.layouts.category_filter',['categories'=>$categories])
        <div class="d-inline align-top">
            <button class="btn btn-dark d-inline" type="submit" name=filter>Go</button>
        </div>
        </div>
    </div>
    </form>
    @if(session('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('fail') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="clearfix my-3">
        <a class="btn btn-dark" href="/admin/products/create">Add New Product</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-sm table-borderless mt-4">
            <tr>
                <thead class="border-bottom">
                    <th scope="col">Product Name</th>
                    <th scope="col" class="d-none d-md-table-cell">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
            
                </thead>
            </tr>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ capitalize($product->product_name)}}</td>
                    <td class="d-none d-md-table-cell">{{ $product->product_category ? capitalize($product->product_category) : 'Master'}}</td>
                    <td>{{ $product->product_price }}</td>
                    <td class="text-right">
                    <a class="btn btn-secondary d-inline-block" href="/admin/products/{{ $product->product_name }}/edit">Edit</a>
                    <form method="POST" class="d-inline-block" action="/admin/products/{{ $product->product_name }}">
                        @csrf
                        @method('DELETE')
                    <button type="submit" class="btn btn-primary d-inline">Delete</button>
                    </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @if($products->isEmpty()) 
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>No Products To Show</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
        <div class="text-left">
            <a class="btn btn-primary" href="/admin">Back</a>
        </div>
    </article>
</section>

        </main>
@endsection