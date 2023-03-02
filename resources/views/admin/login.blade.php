{{-- 
  The login view.
  It's used to let the user p[erform login operations.
  Shows the elements required for user login
  --}}
<!doctype html>
<html lang="en" class="h-100">
  <head>
  	<title>Birkbeck Canteen Admin - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/media/icons/favicon.png') }}"/>
	</head>
	<body class="h-100">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-md-7 col-lg-5">
					<div class="p-4 p-md-3  text-center">
                        <img class="img-fluid rounded mb-2" src="{{ asset('storage/media/logo/mgcanteenlogo.png') }}" alt="logo">
                        <h3 class="text-center my-4">Sign In</h3>
                        @if(session('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('fail') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif
                        @error('username')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @enderror
                                @error('password')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
						<form action="/admin/trylogin" class="login-form" method="POST" id="login_form">
                            @csrf
                                <div class="form-group">    
                                <input type="text" name="username" class="form-control rounded-left" placeholder="Username">
                            </div>
	            <div class="form-group">
	              <input type="password" name="password" class="form-control rounded-left" placeholder="Password">
	            </div>
	            <div class="form-group">
	            </div>
	          </form>
            <div class="clearfix">
              <a href="/" class="btn btn-primary rounded float-left d-block ">Cancel</a>
              <button type="submit" form="login_form" class="btn btn-dark rounded submit px-3 d-block  float-right">Login</button>
            </div>
	        </div>
				</div>
			</div>
		</div>
        <script src="{{ asset('js/app.js') }}"></script>
	</body>
</html>