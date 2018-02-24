  <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    @include('master/head')
  </head>
  <body>
    @include('master/navbar')
    <main>
      <div class="container mt-3">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                Login
              </div>
              <div class="card-body">
                <form action="{{route('login')}}" method="post" class="needs-validation" novalidate>
                  <div class="row">
                    <div class="col-md-8">
                      @csrf
                        @if ($errors->has('email'))
                      <div class="form-group row text-center">
                        <div class="col-12">
                          <div class="alert alert-danger" role="alert">
                            {{ $errors->first('email') }}
                          </div>
                        </div>
                      </div>
                        @endif
                      <div class="form-group row">
                          <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                              <div class="invalid-feedback">
                                Please Provide A Valid Email Id
                              </div>

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                              <div class="invalid-feedback">
                                Enter Password
                              </div>
                              @if ($errors->has('password'))
                                  <span class="invalid-feedback">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Login
                              </button>

                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                  Forgot Your Password?
                              </a>
                          </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    @include('master/scripts')
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
