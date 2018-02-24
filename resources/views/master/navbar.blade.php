<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/"> <h5>Scroll</h5> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

          </ul>
          <div class=" my-2 my-lg-0">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 ">
              <li class="nav-item">
                <a class="nav-link active" href="/">Timeline</a>
              </li>
              @if(Auth::check())
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  @if(Auth::user()->avatar)
                  <img src="{{Auth::user()->avatar}}" class="img-fluid rounded-circle" alt="" width="30px">
                  @else
                  <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="" width="30px">
                  @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/profile">Change Profile Pic</a>
                  <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" name="button" class="dropdown-item btn btn-link">Logout</button>
                  </form>
                </div>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link active" href="{{route('login')}}">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active " href="{{route('register')}}">Sign Up</a>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </nav>
</header>
