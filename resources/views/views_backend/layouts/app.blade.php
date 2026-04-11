<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'InApp Inventory Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/backend/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/backend/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/backend/favicon_io/favicon-16x16.png') }}">
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css" rel="stylesheet">
  <!-- Dropzone CSS -->
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
  <!-- Tabler Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/backend/style.css') }}">
  @yield('extra-css')
</head>

<body>
  <div id="overlay" class="overlay"></div>

  <!-- TOPBAR -->
  <nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
    <button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm ">
      <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>

    <!-- MOBILE -->
    <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
      <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>
    <div>
      <!-- Navbar nav -->
      <ul class="list-unstyled d-flex align-items-stretch mb-0 gap-1">
        <!-- Pages link -->
        <li class="ms-3">
            <h4 class="mb-0 small d-inline">{{ Auth::user()->full_name ?? 'User' }}</h4>
          <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger mt-2">
              <i class="ti ti-logout"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </nav>

  <!-- SIDEBAR -->
  <aside id="sidebar" class="sidebar overflow-y-auto overflow-x-hidden">
    <div class="logo-area">
      <a href="{{ route('admin.dashboard') }}" class="d-inline-flex">
        <img src="{{ asset('images/backend/logo-icon.svg') }}" alt="" width="24">
        <span class="logo-text ms-2"><img src="{{ asset('images/backend/logo.svg') }}" alt=""></span>
      </a>
    </div>
    <ul class="nav flex-column">
      <li class="nav-text-space"><small class="nav-text text-muted">Main</small></li>
      <li><a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif"
          href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a>
      </li>
      <li><a class="nav-link @if(request()->routeIs('admin.event-list')) active @endif"
          href="{{ route('admin.event-list') }}"><i class="ti ti-box-seam"></i><span class="nav-text">Event
            List</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.reports')) active @endif"
          href="{{ route('admin.reports') }}"><i class="ti ti-receipt"></i><span class="nav-text">Reports</span></a>
      </li>

      <li class="nav-text-space"><small class="nav-text text-muted">Event</small></li>
      <li><a class="nav-link @if(request()->routeIs('admin.create-event')) active @endif"
          href="{{ route('admin.create-event') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Event</span></a>
      </li>
      <li><a class="nav-link @if(request()->routeIs('admin.edit-product')) active @endif"
          href="{{ route('admin.edit-product') }}"><i class="ti ti-edit"></i><span class="nav-text">Edit
            Product</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.product-details')) active @endif"
          href="{{ route('admin.product-details') }}"><i class="ti ti-eye"></i><span class="nav-text">Product
            Details</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.product-categories')) active @endif"
          href="{{ route('admin.product-categories') }}"><i class="ti ti-category"></i><span
            class="nav-text">Categories</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.product-brands')) active @endif"
          href="{{ route('admin.product-brands') }}"><i class="ti ti-building-plus"></i><span
            class="nav-text">Brands</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.product-variants')) active @endif"
          href="{{ route('admin.product-variants') }}"><i class="ti ti-palette"></i><span
            class="nav-text">Variants</span></a></li>

      <li class="nav-text-space"><small class="nav-text text-muted">Inventory / Stock</small></li>
      <li><a class="nav-link @if(request()->routeIs('admin.stock-overview')) active @endif"
          href="{{ route('admin.stock-overview') }}"><i class="ti ti-clipboard"></i><span class="nav-text">Stock
            Overview</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.stock-in')) active @endif"
          href="{{ route('admin.stock-in') }}"><i class="ti ti-package-import"></i><span class="nav-text">Stock In / Add
            Stock</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.stock-out')) active @endif"
          href="{{ route('admin.stock-out') }}"><i class="ti ti-package-export"></i><span class="nav-text">Stock Out /
            Remove</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.low-stock-products')) active @endif"
          href="{{ route('admin.low-stock-products') }}"><i class="ti ti-alert-triangle"></i><span class="nav-text">Low
            Stock Products</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.stock-expired')) active @endif"
          href="{{ route('admin.stock-expired') }}"><i class="ti ti-clock"></i><span class="nav-text">Expired
            Stock</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.warehouse-location-management')) active @endif"
          href="{{ route('admin.warehouse-location-management') }}"><i class="ti ti-map-pin"></i><span
            class="nav-text">Warehouse Location</span></a></li>

      <li class="nav-text-space"><small class="nav-text text-muted">Orders & Sales</small></li>
      <li><a class="nav-link @if(request()->routeIs('admin.order-list')) active @endif"
          href="{{ route('admin.order-list') }}"><i class="ti ti-shopping-cart"></i><span class="nav-text">Order
            List</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.order-details')) active @endif"
          href="{{ route('admin.order-details') }}"><i class="ti ti-file-search"></i><span class="nav-text">Order
            Details</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.create-order')) active @endif"
          href="{{ route('admin.create-order') }}"><i class="ti ti-folder"></i><span class="nav-text">Create New
            Order</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.invoice')) active @endif"
          href="{{ route('admin.invoice') }}"><i class="ti ti-file-text"></i><span class="nav-text">Invoice</span></a>
      </li>
      <li><a class="nav-link @if(request()->routeIs('admin.returns-refunds')) active @endif"
          href="{{ route('admin.returns-refunds') }}"><i class="ti ti-squares"></i><span class="nav-text">Returns /
            Refunds</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.pos')) active @endif" href="{{ route('admin.pos') }}"><i
            class="ti ti-navigation-pin"></i><span class="nav-text">Pos(Point of Sale)</span></a></li>

      <li class="nav-text-space"><small class="nav-text text-muted">Account</small></li>
      <li><a class="nav-link" href="{{ route('admin.signin') }}"><i class="ti ti-logout"></i><span class="nav-text">Log
            in</span></a></li>
      <li><a class="nav-link" href="{{ route('admin.signup') }}"><i class="ti ti-user-plus"></i><span
            class="nav-text">Sign up</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.user-roles')) active @endif"
          href="{{ route('admin.user-roles') }}"><i class="ti ti-user-screen"></i><span class="nav-text">User
            Roles</span></a></li>

      <li class="nav-text-space"><small class="nav-text text-muted">Utilities</small></li>
      <li><a class="nav-link @if(request()->routeIs('admin.error-404')) active @endif"
          href="{{ route('admin.error-404') }}"><i class="ti ti-alert-circle"></i><span class="nav-text">404
            Error</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.docs')) active @endif" href="{{ route('admin.docs') }}"><i
            class="ti ti-file-text"></i><span class="nav-text">Docs</span></a></li>
      <li><a class="nav-link @if(request()->routeIs('admin.changelog')) active @endif"
          href="{{ route('admin.changelog') }}"><i class="ti ti-exchange"></i><span
            class="nav-text">Changelog</span></a></li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main id="content" class="content py-15">
    <div class="container-fluid">
      @yield('content')
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js"></script>
  <!-- Dropzone JS (File Upload) -->
  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
  <!-- ApexCharts (Official CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- Custom JS -->
  <script src="{{ asset('js/backend/main.js') }}"></script>
  <script src="{{ asset('js/backend/custom.js') }}"></script>
  <script src="{{ asset('js/backend/chart.js') }}"></script>
  @yield('extra-js')
</body>

</html>