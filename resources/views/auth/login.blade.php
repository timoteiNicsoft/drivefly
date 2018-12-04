<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>DriveFly</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.js"></script>

</head>

<body id="LoginForm">
  <div class="container-fluid login-page">
    <div class="row d-flex align-items-center">
        <div class="col-md-3 mx-auto">
          <!-- form card login -->
          <div class="">
              <div class="">
                  <h3 class="text-center mb-3"><img src="{{ 'build/images/df-logo.png' }}" class="logo-adj"></h3>
              </div>
              <div class="">

                  <form class="form text-center" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST" action="{{ route('login') }}">
                     @csrf

                     <div class="form-group">
                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-lg roundedm text-center" name="email" value="{{ old('email') }}" required autofocus placeholder="Username">
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Oops, you missed this one.</strong>
                        </span>
                        @endif
                  </div>
                  <div class="form-group text-center">
                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-lg roundedm text-center" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>Enter your password too!</strong>
                        </span>
                        @endif
                  </div>

                  <button type="submit" name="submit" class="btn btn-secondary btn-lg btn-block form-control-button" id="btnLogin">Login</button>
              </form>
          </div>
      </div>
  </div>
</div>
</div>

</body>
</html>
