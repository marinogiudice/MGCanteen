@extends('layouts.public')
@section('content')
    <main class="container mt-3 my-md-5 min-vh-100">
        <h1 class="text-center">Get In Touch</h1>
        <h2 class="text-center my-5"> Please send us a message using the form below</h2>
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>{{ session('status') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif 
        <form class="mx-auto" id="send_email" method="POST" action="/contactus/sendmessage">
            @csrf
            @error('name')
                <span class="error_text name_error">{{ $message }}</span>
            @enderror
        <div class=" form-group mb-2 mx-auto p-0">
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
        </div>
        @error('email')
            <span class="error_text email_error">{{ $message }}</span>
        @enderror
        <div class="form-group mb-2 mx-auto p-0">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        @error('message')
            <span class="error_text message_error">{{ $message }}</span>
        @enderror
        <div class="form-group mb-2 mx-auto p-0" style="background-color:#eaf1fb">
            <textarea class="form-control" rows="10" placeholder="Leave your Message Here" name="message">{{ old('message') }}</textarea>
        </div>
        
        <div class="form-group clearfix mb-0">
            <div id="recaptcha" class="g-recaptcha mb-3 float-left" data-sitekey="6Lc9fvgiAAAAAAJzfgbQtraNZKL5V2RNmoTgAWxu"></div>
            
            <input type="submit" class="btn btn-dark float-right">
            
            
        </div>
        @error('g-recaptcha-response')
        <span class="error_text recaptcha_error d-block">{{ $message }}</span>
        @enderror
        
        </form>
    </main>
@endsection