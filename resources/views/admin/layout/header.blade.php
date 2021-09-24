<ul class="navbar-nav" id="navbar-header">
    <li class="nav-item">
      <h4 class="mb-0 d-inline-block font-weight-bold">
        Brain
      </h4>
      <h3 class="text-primary d-inline-block">
        Storm <!--span class="logo-span"></span-->
      </h3>
    </li>
    <li class="nav-item">
      {{-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> --}}
      <button class="nav-link menu opened" data-widget="pushmenu" onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'))" aria-label="Main Menu">
        <svg width="28" height="28" viewBox="0 0 100 100">
        <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
        <path class="line line2" d="M 20,50 H 80" />
        <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
        </svg>
    </button>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <!--li class="nav-item dropdown">
      <a class="nav-link lang dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-language text-lg text-dark"></i>
      </a>
      <div class="dropdown-menu dropdown-menu dropdown-menu-right">
          <a href="" class="dropdown-item @if(Session::has('locale')) @if(Session::get('locale') == 'en') lang-active @endif @else lang-active @endif">
          English
          </a>
          <a href="" class="dropdown-item @if(Session::has('locale') && Session::get('locale') == 'jp') lang-active @else pl-4 @endif">
          日本語
          </a>
      </div>
    </li-->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user text-primary text-lg"></i>
        {{ Auth::guard('admin')->user()->first_name }}
      </a>
      <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a href="{{ url('/auth/logout') }}" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal">
          <i class="fas fa-user text-primary"></i>
          My Profile
        </a>
        <a href="{{ url('/auth/logout') }}" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal">
          <i class="fas fa-key text-primary"></i>
          Change Password
        </a>
        <a href="{{ route('admin.account.logout') }}" class="dropdown-item">
          <i class="fas fa-sign-out-alt text-primary"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
