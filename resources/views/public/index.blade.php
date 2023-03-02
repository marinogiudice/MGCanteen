{{-- 
  The Index view
  Extends the public view.
  It's used in the public section of the app as homepage.
  Shows the carousel and the introductory text
  --}}
@extends('layouts.public')
@section('content')
<main class="container min-vh-100 px-0">
  <section class="row shadow panel">
    <div class="col px-0 d-none d-md-block">
      <div id="carousel-indicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-indicators" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-indicators" data-slide-to="1"></li>
          <li data-target="#carousel-indicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{ asset('storage/media/slideshow/slideshow1.jpg') }}" alt="slideshow1">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset('storage/media/slideshow/slideshow2.jpg') }}" alt="slideshow2">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset('storage/media/slideshow/slideshow3.jpg') }}" alt="slideshow3">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-indicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-indicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>
  <section class="row shadow panel">
    <article class="col p-4">
      <h3>Embrace the Innovation</h3>
      <p>We are Happy to have you back.</p>
      <p>Meet the changes we introduced for you.</p>
      <p>To make you enjoy your visit in safety but to improve the quality of your staying at the same time you can now order at your table.</p>
      <p>Please don't be shy...</p>
      <a class="btn btn-primary"href="ordering">Order Now!</a>
    </article>
  </section>
</main>
@endsection