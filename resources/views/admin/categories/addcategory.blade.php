{{-- 
    Add Category view Extends the app view
    Shows the elements required to add a category to the system.
    It's also used to add subcategories  
    --}}
@extends('layouts.app')

@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
        @if(isset($category))
            <h2 class="mb-3">Add Category to {{ capitalize($category->category_name) }}</h2>
        @else
            <h2 class="mb-3">Add Category</h2>
        @endif
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
        @if(!isset($category))
            <form action="/admin/categories" method="POST" enctype="multipart/form-data">
        @else
            <form action="/admin/categories/{{ $category->category_name  }}" method="POST" enctype="multipart/form-data">
        @endif
        @csrf
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
                <input type="text" class="form-control" name="category_name" placeholder="Category Name" value="{{ capitalize(old('category_name')) }}">
            </div>
        </div>
        @if(!isset($category))
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
        @endif
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
                    <label for="file">Category Image</label>
                    <input type="file" class="form-control" name="file">
                </div>
            </div>
            <div class="form-row">
                <div class="col form-group text-right">
                    <a class="btn btn-primary" href="/admin/categories">Cancel</a>
                    <button class="btn btn-dark" type="submit">Add</button>
                </div>
            </div>
        </form>
    </article>
</section>
    </main>
@endsection