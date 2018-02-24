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
      <div class="container mt-3" id="app">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                Register
              </div>
              <div class="card-body">
                <form action="/register" method="post" class="needs-validation" novalidate>
                  @csrf
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                              <span class="invalid-feedback">
                                  <strong>Enter Your Name</strong>
                              </span>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                              <span class="invalid-feedback">
                                  <strong>Enter Valid Email Id</strong>
                              </span>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control" name="password" required>
                              <span class="invalid-feedback">
                                  <strong>Enter Password</strong>
                              </span>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                              <span class="invalid-feedback">
                                  <strong>Confirm Password Does Not Match</strong>
                              </span>
                          </div>
                      </div>
                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Register
                              </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
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
    <script type="text/javascript">
    var password = document.getElementById("password") , confirm_password = document.getElementById("password-confirm");

      function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
      }

      password.onchange = validatePassword;
      confirm_password.onkeyup = validatePassword;
    </script>
  </body>
</html>
