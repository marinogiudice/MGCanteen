{{-- 
  The app view layout.
  It's used as "master view"
  The other views inherith from it.
  Contain the common elements, like footer and navbar, to display in all the views who extend it.
  --}}
<!doctype html>
<html lang="en">
  <head>
	  <title>MG Canteen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <link rel="stylesheet"  href="{{ asset('css/app.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}"/>
  </head>
  <body class="ls-1 ls-md-2 ls-xl-3">
    <header class="container shadow d-none d-md-block panel mt-2">
      <div class="row justify-content-between">
        <div class="col-4">
          <img class="logo img-fluid" src="{{ asset('storage/media/logo/mgcanteenlogo.png') }}" alt="logo">
        </div>
        <div class=" col-8 col-md-8 col-xl-8  pl-xl-0 align-self-center">
            <h1 class="display-3">MG Canteen</h1>
        </div>
      </div>
    </header>
    <div class="container shadow">
      <div class="row mb-0">
        <nav class="col navbar navbar-expand-md navbar-dark bg-dark">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavUl">
            <span class="navbar-toggler-icon"></span>
          </button>
          @php
          $qty=0;
            if(isset($cart)) {
              $qty=$cart->totalQty;
            } 
          @endphp
          <a class="navbar-brand d-md-none" href="/">MG Canteen</a>
          <img class="navbar-brand d-md-none  mr-0" src="{{ asset('storage/media/logo/mgcanteenlogoxs.png') }}" alt="logo">
          @auth
          <div class="collapse navbar-collapse justify-content-center" id="mainNavUl">
            <ul class="navbar-nav">
                <li class="nav-item {{ request()->is('admin') ? 'active' : ''}}"><a class="nav-link" href="/admin">Home</a></li>
                <li class="nav-item {{ request()->is('admin/categories*') ? 'active' : ''}}"><a class="nav-link" href="/admin/categories">Categories</a></li>
                <li class="nav-item {{ request()->is('admin/products*') ? 'active' : ''}}"><a class="nav-link" href="/admin/products">Products</a></li>
                <li class="nav-item {{ request()->is('admin/tables*') ? 'active' : ''}}"><a class="nav-link" href="/admin/tables">Tables</a></li>
                <li class="nav-item {{ request()->is('admin/order*') ? 'active' : ''}}"><a class="nav-link" href="/admin/orders">Orders</a></li>
            </ul>
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="/admin/logout">Logout</a></li>
            </ul>
          </div>
          @endauth
        </nav>
      </div>
    </div>
    <div class="container min-vh-100">
    @yield('content')
    </div>
    <footer class="container">
        <div class="row mt-5 mb-2">
          <ul class=" col-12 nav justify-content-center p-1">
            <li class="nav-item">
              <a class="nav-link" href="#">Accessibility</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Privacy</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Corporate</a>
            </li>
          </ul>
          <div class="col-12 mb-3 border-top">
            <p class="text-center small mt-2 mb-0">Copyright &copy; MG Canteen 2022</p>
            <p class="text-center small mt-0">All Rights Reserved</p>
          </div>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
