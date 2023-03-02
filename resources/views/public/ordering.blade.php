{{-- 
    The ordering view.
    Extends the public view.
    It's used in the public section of the website as entry point of the ordering component.
    Shows the list of category and product items.
    --}}
@extends('layouts.public')
@section('content')
<nav class="row px-0 panel shadow">
    <ol class="col breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="/ordering">Ordering</a></li>
      @isset($category)
      <li class="breadcrumb-item active font-weight-bold">{{ capitalize($category->category_name) }}</li>
      @endisset
    </ol>
  </nav>
<main class="container px-0 min-vh-100 mt-2">
    @isset($category)
        <h2 class="mt-3">{{ capitalize($category->category_name) }}</h2>
    @endisset
    <div class="row">
             
        @isset($categories)
        @foreach ( $categories as $category )
        <div class="col-md-6 col-lg-4 col-xl-3  ">         
            <div class="card text-center flex-row flex-md-column shadow mt-3" >
                @php
                    $pic=$category->image_path;
                    if(!isset($category->image_path)) {
                        $pic='media/noimageavailable.png';       
                    }
                @endphp
                <div class="d-none d-sm-block card-body p-0  col-sm-4  col-md-12 ratio ratio-4x3">
                    <img class="img-fluid h-100"   src="{{ asset('storage/'.$pic) }}">
                </div> 
                <div class="card-footer col-xs-12 col-sm-8   col-md-12 align-self-center border-0  " style="background-color: #ffffff;">
                    <h2 class="col text-md-center col-md-12 text-center"><a href="{{ '/ordering/'.$category->category_name }}">{{ capitalize($category->category_name) }}</a></h2>
                </div>
            </div>
        </div>
        @endforeach
        @endisset
    </div>
    <div class="row">
        @isset($products)
        @foreach($products as $product)
        <div class="col-md-6 col-lg-4 col-xl-3">         
            <div class="card text-center flex-row flex-md-column shadow mt-3" >
                @php
                    $pic=$product->product_pic;
                    if(!isset($product->product_pic)) {
                        $pic='media/noimageavailable.png';    
                        
                    }      
                @endphp
                <div class="card-img-top d-none d-sm-block card-body p-0  col-sm-4  col-md-12 ratio ratio-4x3">
                    <img class="img-fluid h-100"   src="{{ asset('storage/'.$pic) }}">
                </div> 
                <div class="card-footer col-12 col-sm-8   col-md-12 align-self-center border-0  " style="background-color: #ffffff;">
                    <div class="row">
                        <h4 class="col-9 text-md-center col-md-12 text-left">{{ capitalize($product->product_name) }}</h4>
                        <p class="col-3 col-md-12  text-right text-md-center pl-0 px-md-0">{{$product->product_price." £"}}
                    </div>
                    <div class="row  ">
                        <div class="col">
                            <p>{{capitalize($product->product_description) }}</p>
                        </div>
                    </div>      
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ '/ordering/addtocart/'.$product->product_name }}" class="btn btn-secondary btn-block mt-2">Add to Order</a>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
        @endforeach
        @endisset
    </div>
    @isset($products)
    @if($products->isEmpty() && $categories->isEmpty())
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <strong>No Products To Show</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @endisset
</main>
@endsection