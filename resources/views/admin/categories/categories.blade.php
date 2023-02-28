{{-- 
    Categories view. 
    
    it's the homepage of the categories section
    extends the app view. Includes the category filter layout view
    Shows the element to add a new category and the category listing.
    It's also used to show a subcategory. 
    
     --}}
@extends('layouts.app')
@section('content') 
    <main class="container d-flex flex-column min-vh-100 px-0">
        <section class="row panel shadow">
            <article class="col p-4">
                <h2 class="mb-3">{{ request()->is('admin/categories*') && isset($name) ? capitalize($name).' Category': 'Categories'}}</h2>
                <form method="post" action="/admin/categories/filter">
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
                @if(request()->is('admin/categories*') && isset($name))
                    <a class="btn btn-dark" href="{{'/admin/categories/create/'.$name }}">Add New Category</a>
                @else
                    <a class="btn btn-dark" href="/admin/categories/create">Add New Category</a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm table-borderless">
                    <thead class="border-bottom">
                        <th scope="col">Category Name</th>
                        <th scope="col"></th>        
                    </thead>
                    <tbody>
                        @foreach($paginatedCategories as $category)
                        @php $ident= str_repeat('- ',$category->get('depth'));@endphp
                        <tr>
                            <td><a class="text-primary" href="{{ '/admin/categories/'.$category->get('category')->category_name }}">{{ $ident.capitalize($category->get('category')->category_name)}}</a></td>
                            <td class="text-right">
                                <a class="btn btn-secondary d-inline-block" href="/admin/categories/{{ $category->get('category')->category_name }}/edit">Edit</a>
                                <form method="POST" class="d-inline-block" action="/admin/categories/{{ $category->get('category')->category_name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary d-inline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($paginatedCategories->isEmpty()) 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>No Sub Categories To Show</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="d-flex justify-content-center">
                {!! $paginatedCategories->links() !!}
            </div>
            <div class="text-left">
                <a class="btn btn-primary" href="/admin">Back</a>
            </div>
        </article>
    </section>
</main>
@endsection