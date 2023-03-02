{{-- 
  The public view
  It's used to display the common elements of the public section of the app, like footer and navbar
  It's extended where required
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
      
      <!-- header grid row content container -->
      <div class="row justify-content-between">
        
        <!-- grid row column 1 -->
        <div class="col-4">
          <img class="logo img-fluid" src="{{ asset('storage/media/logo/mgcanteenlogo.png') }}" alt="logo">
        </div>
        <!-- end grid column 1 -->

        <!-- grid column 2 -->
        <div class=" col-8 col-md-8 col-xl-8  pl-xl-0 align-self-center">
            <h1 class="display-3">MG Canteen</h1>
        </div>
       
        <!-- end grid column 2-->

      </div>
      <!-- end header grid row content container -->

    </header>
    @php
      $qty=0;
      if(isset($cart)) {
        $qty=$cart->totalQty;
      }     
    @endphp
    <div class="container shadow">
      <div class="row mb-0">

        <!-- Navbar Component Expands on medium displays 
              -->
        <nav class="col navbar navbar-expand-md navbar-dark bg-dark">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavUl">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <!-- navbar brand elements -->
          <a class="navbar-brand d-md-none" href="/">MG Canteen</a>
          <div class="d-md-none">
            <a class="navbar-brand" href="/ordering/order/cart">
              <img src="{{ asset('storage/media/icons/cart-icon.png') }}" alt="logo">{{ $qty }}
            </a>
          </div>
          <!-- end navbar brand elements-->

          <!-- Collapsible Element -->
          <div class="collapse navbar-collapse justify-content-center" id="mainNavUl">
            <ul class="navbar-nav">
                <li class="nav-item {{ request()->is('/') ? 'active' : ''}}"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item {{ request()->is('ordering*') ? 'active' : ''}}"><a class="nav-link" href="/ordering">Order Now</a></li>
                <li class="nav-item {{ request()->is('contactus*') ? 'active' : ''}}"><a class="nav-link" href="/contactus">Contact Us</a></li>
            </ul>
          </div>
          <div class="d-none d-md-block">
            <a class="navbar-brand" href="/ordering/order/cart">
              <img src="{{ asset('storage/media/icons/cart-icon.png') }}" alt="logo">{{ $qty }}
            </a>
        </div>
          <!-- end collapsible element -->
        </nav>
        <!-- End navbar component -->
      </div>
    </div>
    <div class="container min-vh-100">

    @yield('content')

    </div>

    <!-- footer -->
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
    <!-- end footer -->

    <!-- scripts required from bootstrap -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- scripts required from google recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- end scripts-->
  </body>
</html>
