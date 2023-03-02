{{-- 
  The index view.
  Extends the app view.
  It's the index page of the management component
  Shows the button links to the component sections.
  --}}
@extends('layouts.app')
@section('content')
    <main class="mb-5 min-vh-100">
      <section class="row panel shadow"> 
        <div class="col mt-5 pb-5 text-center mt-0">
          <a class="btn btn-dark btn-lg m-3" style="width:50%" href="/admin/categories">Categories</a>
          <a class="btn btn-dark btn-lg m-3" style="width:50%" href="/admin/products">Products</a>
          <a class="btn btn-dark btn-lg m-3" style="width:50%" href="/admin/tables">Tables</a>
          <a class="btn btn-dark btn-lg m-3" style="width:50%" href="/admin/orders">Orders</a>
          <a class="btn btn-primary btn-lg m-3" style="width:50%" href="/admin/logout">Logout</a>
        </div>
      </section>
  </main>    
@endsection