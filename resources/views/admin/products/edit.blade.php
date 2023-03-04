{{-- Edit Product view
    Extends the app view
    Shows the elements required for the edit operations of a product 
    --}}
@extends('layouts.app')
@section('content')
<main class="min-vh-100">
    <section class="row panel shadow">
        <article class="col p-4">
        <h2 class="mb-3">Edit Product  {{ capitalize($product->product_name) }}</h2>
       
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
    
        <form id="deletePic"action="/admin/products/{{ $product->product_name }}/delpic" method="POST">
            @csrf
        </form>
        
        <form id="editProduct" action="/admin/products/{{ $product->product_name }}" method="POST" enctype="multipart/form-data">
            @csrf
        @method('PUT')
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
                <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="{{ capitalize($product->product_name) }}">
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
    
    @include('admin.layouts.category_filter',['categories'=>$categories, 'product'=> $product])
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
    <div class=" col form-group">
        <label for="product_price">Product Price</label>
        <input class="form-control" type="number" step="any" name="product_price" value="{{ $product->product_price }}">
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
                    <textarea class="form-control" name="product_description" rows="5">{{ $product->product_description }}</textarea>
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
        @if(!$product->product_pic)
        <div class="form-row">
            <div class="col form-group">
                <label for="file">Product Image</label>
                <input type="file" class="form-control"  name="file">
            </div>
        </div>
        @endif
        <div class="form-row">
            <div class="col form-group clearfix">
                
            <a class="btn btn-primary float-left" href="/admin/products">Cancel</a>
            
            <button class="btn btn-dark float-right" type="submit" form="editProduct">Save</button>
            @if($product->product_pic) 
                <button class="btn btn-secondary float-right mr-1" type="submit" form="deletePic">Delete Picture</button>
            @endif
            </div>
        </div>
        @if($product->product_pic)
        <img class="img-fluid" src="{{ asset('storage/'.$product->product_pic) }}"/>
        @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>No Image assigned to this Product</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </main>
</section>
</article>
    @endif
@endsection