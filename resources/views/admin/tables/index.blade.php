{{-- 
    The table index view.
    Extends the app view
    It's the index page of the tables section.
    Shows add new table button and a table listing.
    includes the layout table_select to let the user filter the table listing result based on the table number
    --}}
@extends('layouts.app')
@section('content')
<main class="container d-flex flex-column min-vh-100 px-0">
    <section class="row panel shadow">
        <article class="col p-4">
            
    <h2 class="mb-3 mt-4">Tables</h2>
    
    <form method="post" action="/admin/tables/filter">
        @csrf
        @error('table')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
        @include('layouts.tables_select',['tables' => $tables])
                <div class="col align-self-end px-0">
                    <button class="btn btn-dark d-inline" type="submit" name=filter>Go</button>
                </div>
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
                <a class="btn btn-dark" href="/admin/tables/create">Add New Table</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm table-borderless">
                    <thead class="border-bottom">
                        <th scope="col">Table Number</th>
                        <th scope="col"></th>
                    
                    </thead>
                    <tbody>
                    @foreach($paginatedTables as $table)
                    <tr>
                        <td><a class="text-primary">{{  $table->table_number }}</a></td>
                        <td class="text-right">
                        <a class="btn btn-secondary d-inline-block" href="/admin/tables/{{ $table->table_number }}/edit">Edit</a>
                        <form method="POST" class="d-inline-block" action="/admin/tables/{{ $table->table_number }}">
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
                 @if($paginatedTables->isEmpty()) 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>No Tables To Show</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            <div class="d-flex justify-content-center">
                {!! $paginatedTables->links() !!}
            </div>
            <div class="text-left mt-3">
                <a class="btn btn-primary" href="/admin">Back</a>
            </div>        
        </article>
    </section>
</main>
            
                  
@endsection