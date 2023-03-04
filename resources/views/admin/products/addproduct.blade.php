{{-- 
    Addproducts view.
    Extends the app view
    Shows the elements required for the creation of a new product.
    includes the category_filter layout as select options list to let the user select the parent category
    --}}
@extends('layouts.app')
@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
    <h2 class="mb-3">Add New Product</h2>
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
    <form action="/admin/products" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col form-group">
                @error('product_name')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="{{ capitalize(old('product_name')) }}">
            </div>
        </div>
        @error('category')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        @include('admin.layouts.category_filter',['categories'=>$categories])
        </div>
        </div>
        
        @error('product_price')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        <div class="form-row">
            <div class="col form-group">
                <label for="product_price">Product Price</label>
                <input type="number" step="any" class="form-control" name="product_price" placeholder="Product Price" value="{{ old('product_price') }}">
            </div>
        </div>
    
        @error('product_description')
            <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        <div class="form-row">
            <div class=" col form-group">
                <label for="product_description">Product Description</label>
                <textarea class="form-control" name="product_description" rows="5">{{ old('product_description') }}</textarea>
            </div>
        </div>
            
        @error('file')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        <div class="form-row">
            <div class="col form-group">
                <label for="file">Product Image</label>
                <input type="file" class="form-control" name="file">
            </div>
        </div>
        <div class="form-row">
            <div class="col form-group clearfix">
            <a class="btn btn-primary float-left" href="/admin/products">Cancel</a>
            <button class="btn btn-dark float-right" type="submit">Add</button>
            </div>
        </div>
    </form>
        </article>
    </section>
</main>
@endsection