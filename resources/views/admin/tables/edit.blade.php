@extends('layouts.app')
@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
    <h2 class="mb-3 mt-4">Edit Table  {{ $table->table_number }}</h2>
       
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
    <form action="/admin/tables/{{ $table->table_number }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="col form-group">
                @error('table_number')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                <label for="table_number">Table Number</label>
                <input type="text" class="form-control" name="table_number" placeholder="Table Number" value="{{ $table->table_number }}">
            </div>
        </div>
        <div class="form-row">
            <div class="col form-group clearfix">
                
            <a class="btn btn-primary float-left" href="/admin/tables">Cancel</a>
            
            <button class="btn btn-dark float-right" type="submit">Save</button>
            
            </div>
        </div>
        </article
    </section>
</main>
@endsection