{{-- 
    Edit Category view, shows the elements to edit a category information.
    extends the app view.
    includes the category filter view as element to let the user select the parent category
    --}}
@extends('layouts.app')
@section('content')
<main>
    <section class="row panel shadow">
        <article class="col p-4">
        
    
        <h2 class="mb-3">Edit Category  {{ capitalize($category->category_name) }}</h2>
       
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
    
        <form id="deletePic"action="/admin/categories/{{ $category->category_name }}/delpic" method="POST">
            @csrf
        </form>
        
        <form id="editCategory" action="/admin/categories/{{ $category->category_name }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="col form-group">
                @error('category_name')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" name="category_name" placeholder="Category Name" value="{{ capitalize($category->category_name) }}">
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
        
        @include('admin.layouts.category_filter',['categories'=>$categories, 'category'=> $category])
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
       
        @if(!$category->image_path)
        
        
        <div class="form-row">
            <div class="col form-group">
                <label for="file">Category Image</label>
                <input type="file" class="form-control"  name="file">
            </div>
        </div>
        @endif
        

    

        <div class="form-row">
            <div class="col form-group clearfix">
                
            <a class="btn btn-primary float-left" href="/admin/categories">Cancel</a>
            
            <button class="btn btn-dark float-right" type="submit" form="editCategory">Save</button>
            @if($category->image_path) 
                <button class="btn btn-secondary float-right mr-1" type="submit" form="deletePic">Delete Picture</button>
            @endif
            </div>
        </div>
    
    @if($category->image_path)
        <img class="img-fluid" src="{{ asset('storage/'.$category->image_path) }}"/>
        @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>No Image assigned to this Category</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    </article>
</section>
</main>

@endsection