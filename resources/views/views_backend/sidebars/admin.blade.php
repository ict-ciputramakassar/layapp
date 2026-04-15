<!-- ADMIN SIDEBAR -->
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
    <li><a class="nav-link @if(request()->routeIs('reports')) active @endif"
        href="{{ route('reports') }}"><i class="ti ti-receipt"></i><span class="nav-text">Reports</span></a>
    </li>

    <li class="nav-text-space"><small class="nav-text text-muted">Event</small></li>
    <li><a class="nav-link @if(request()->routeIs('admin.create-event')) active @endif"
        href="{{ route('admin.create-event') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Event</span></a>
    </li>
    <li><a class="nav-link @if(request()->routeIs('edit-product')) active @endif"
        href="{{ route('edit-product') }}"><i class="ti ti-edit"></i><span class="nav-text">Edit
          Product</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('product-details')) active @endif"
        href="{{ route('product-details') }}"><i class="ti ti-eye"></i><span class="nav-text">Product
          Details</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('product-categories')) active @endif"
        href="{{ route('product-categories') }}"><i class="ti ti-category"></i><span
          class="nav-text">Categories</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('product-brands')) active @endif"
        href="{{ route('product-brands') }}"><i class="ti ti-building-plus"></i><span
          class="nav-text">Brands</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('product-variants')) active @endif"
        href="{{ route('product-variants') }}"><i class="ti ti-palette"></i><span
          class="nav-text">Variants</span></a></li>

    <li class="nav-text-space"><small class="nav-text text-muted">Inventory / Stock</small></li>
    <li><a class="nav-link @if(request()->routeIs('stock-overview')) active @endif"
        href="{{ route('stock-overview') }}"><i class="ti ti-clipboard"></i><span class="nav-text">Stock
          Overview</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('stock-in')) active @endif"
        href="{{ route('stock-in') }}"><i class="ti ti-package-import"></i><span class="nav-text">Stock In / Add
          Stock</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('stock-out')) active @endif"
        href="{{ route('stock-out') }}"><i class="ti ti-package-export"></i><span class="nav-text">Stock Out /
          Remove</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('low-stock-products')) active @endif"
        href="{{ route('low-stock-products') }}"><i class="ti ti-alert-triangle"></i><span class="nav-text">Low
          Stock Products</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('stock-expired')) active @endif"
        href="{{ route('stock-expired') }}"><i class="ti ti-clock"></i><span class="nav-text">Expired
          Stock</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('warehouse-location-management')) active @endif"
        href="{{ route('warehouse-location-management') }}"><i class="ti ti-map-pin"></i><span
          class="nav-text">Warehouse Location</span></a></li>

    <li class="nav-text-space"><small class="nav-text text-muted">Orders & Sales</small></li>
    <li><a class="nav-link @if(request()->routeIs('order-list')) active @endif"
        href="{{ route('order-list') }}"><i class="ti ti-shopping-cart"></i><span class="nav-text">Order
          List</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('order-details')) active @endif"
        href="{{ route('order-details') }}"><i class="ti ti-file-search"></i><span class="nav-text">Order
          Details</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('create-order')) active @endif"
        href="{{ route('create-order') }}"><i class="ti ti-folder"></i><span class="nav-text">Create New
          Order</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('invoice')) active @endif"
        href="{{ route('invoice') }}"><i class="ti ti-file-text"></i><span class="nav-text">Invoice</span></a>
    </li>
    <li><a class="nav-link @if(request()->routeIs('returns-refunds')) active @endif"
        href="{{ route('returns-refunds') }}"><i class="ti ti-squares"></i><span class="nav-text">Returns /
          Refunds</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('pos')) active @endif" href="{{ route('pos') }}"><i
          class="ti ti-navigation-pin"></i><span class="nav-text">Pos(Point of Sale)</span></a></li>

    {{-- <li class="nav-text-space"><small class="nav-text text-muted">Account</small></li> --}}
    {{-- <li><a class="nav-link" href="{{ route('auth.login') }}"><i class="ti ti-logout"></i><span class="nav-text">Log
          in</span></a></li>
    <li><a class="nav-link" href="{{ route('auth.signup') }}"><i class="ti ti-user-plus"></i><span
          class="nav-text">Sign up</span></a></li> --}}

    <li class="nav-text-space"><small class="nav-text text-muted">Utilities</small></li>
    <li><a class="nav-link @if(request()->routeIs('error-404')) active @endif"
        href="{{ route('error-404') }}"><i class="ti ti-alert-circle"></i><span class="nav-text">404
          Error</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('docs')) active @endif" href="{{ route('docs') }}"><i
          class="ti ti-file-text"></i><span class="nav-text">Docs</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('changelog')) active @endif"
        href="{{ route('changelog') }}"><i class="ti ti-exchange"></i><span
          class="nav-text">Changelog</span></a></li>
  </ul>
</aside>
