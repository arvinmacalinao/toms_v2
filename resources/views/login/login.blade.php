<!DOCTYPE html>
<html class="login" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('storage/images/logo_icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>
<body>
  <div class="form-container">
      <div class="display-2">
          <img src="{{ asset('storage/images/trace_logo.png') }}" height="100" width="100" alt=""> TOMS
      </div>
      <h3>Travel Order Management System</h3>
      <div class="card">
          <div class="card-header">
              <h2>Please sign-in</h2>
          </div>
          <div class="card-body">
              <form class="form" method="POST" action="{{ route('users.login') }}">
                @csrf
                <div class="form-outline mb-4">
                <input class="form-control form-control-lg" type="text" placeholder="Username" name="username" id="username" maxlength="255" required="required" value="{{ old('username') }}">
                <label class="form-label" for="typeEmailX-2">Username</label>
              </div>

              <div class="form-outline mb-4">
                <input class="form-control form-control-lg" type="password" placeholder="Password" name="password" id="password" maxlength="255" required="required">
                <label class="form-label" for="typePasswordX-2">Password</label>
              </div>

              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-start mb-4">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                <label class="form-check-label" for="form1Example3"> Remember password </label>
              </div>

              <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
              </form>
              @if(strlen($msg) > 0)
  		          <div class="text-danger p-2 fs-5 fw-bold"> {{ $msg }} </div>
  		        @endif
          </div>
      </div>
  </div>
</body>
</html>