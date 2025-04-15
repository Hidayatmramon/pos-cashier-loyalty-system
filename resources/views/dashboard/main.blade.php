<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/dashboard/favicon.png') }}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{ asset('assets/dashboard/css/styles.css') }}" />

  <title>Flexy Bootstrap Admin</title>
    <link href="{{ asset('/assets/dashboard/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/dashboard/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}"
        rel="stylesheet">
        <link href="{{ asset('/dist/css/style.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('plugins/swal2.css') }}">

  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body class="link-sidebar">

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div>
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/dashboard/images/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-aperture"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('product.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-shopping-cart"></i>
                </span>
                <span class="hide-menu">Product</span>
              </a>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('sale.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-shopping-cart"></i>
                </span>
                <span class="hide-menu">Selling</span>
              </a>
            </li>
           
            @if (Auth::user()->role == 'admin')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('user.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">User</span>
              </a>
            </li>
            @endif
          </ul>
        </nav>
        
      </div>
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper">
      <!-- Header Start -->
      <header class="topbar">
        <div class="with-vertical">
          <nav class="navbar navbar-expand-lg p-0">
            <div class="d-block d-lg-none py-4">
              <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/dashboard/images/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" />
                <img src="{{ asset('assets/dashboard/images/light-logo.svg') }}" class="light-logo" alt="Logo-Light" />
              </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
               data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
               aria-label="Toggle navigation">
              <i class="ti ti-dots fs-7"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                      <div class="d-flex align-items-center gap-2 border-start ps-3">
                        <div class="user-profile-img">
                          <img src="{{ asset('assets/dashboard/images/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="flexy-img" />
                        </div>
                        <div class="d-none d-md-flex align-items-center">
                          <h5 class="mb-0 fs-4">Hi,</h5>
                          <h5 class="mb-0 fs-4 fw-semibold ms-1">{{ Auth::user()->name }}</h5>
                          <i class="ti ti-chevron-down"></i>
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                         aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{ asset('assets/dashboard/images/user-1.jpg') }}" class="rounded-circle" width="80" height="80" alt="flexy-img" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-4">{{ Auth::user()->name }}</h5>
                            <span class="mb-1 d-block">{{ Auth::user()->role }}</span>
                            <p class="mb-0 d-flex align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                            </p>
                          </div>
                        </div>

                        <div class="d-grid py-4 px-7 pt-8">
                          <a href="{{ route('logout') }}" class="btn btn-outline-primary">Log Out</a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!-- Header End -->

      <div class="body-wrapper">
        @yield('dashboard')

        <!-- Footer -->
        <footer class="footer py-3 pt-4 bg-white text-center">
          2025© All Rights Reserved by Wrappixel
        </footer>
      </div>
    </div>

    <div class="dark-transparent sidebartoggler"></div>

    <!-- JavaScript Files -->


    <script src="{{ asset('assets/dashboard/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('plugins/swal2.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/dist/js/waves.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/dist/js/custom.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('/assets/dashboard/dist/js/pages/dashboards/dashboard1.js') }}"></script>
    @stack('script')
</body>
</html>
