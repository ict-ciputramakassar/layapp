@extends('views_backend.layouts.app')

@section('title', 'Expired Stock')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6">
      <h1 class="fs-3 mb-1">Expired / Near Expiry Products</h1>
      <p class="mb-0">Monitor and manage products approaching or past expiry dates</p>
    </div>
  </div>
</div>

<!-- Status Cards -->
<div class="row mb-5 g-5">
  <!-- Expired Products Card -->
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25">
      <div class="card-body p-5">
        <div>
          <span class="icon-shape icon-md bg-primary text-white rounded-2">
            <i class="ti ti-trash fs-4"></i>
          </span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-2 fw-bold mb-0 d-block">3</span>
          <span class="fs-5">Expired Products</span>
          <small class="text-muted">Requires immediate action</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Critical Level Card -->
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25">
      <div class="card-body p-5">
        <div>
          <span class="icon-shape icon-md bg-primary text-white rounded-2">
            <i class="ti ti-alert-triangle fs-4"></i>
          </span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-2 fw-bold mb-0 d-block">2</span>
          <span class="fs-5">Critical (≤7 days)</span>
          <small class="text-muted">Expiring within a week</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Warning Level Card -->
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25">
      <div class="card-body p-5">
        <div>
          <span class="icon-shape icon-md bg-primary text-white rounded-2">
            <i class="ti ti-clock fs-4"></i>
          </span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-2 fw-bold mb-0 d-block">2</span>
          <span class="fs-5">Warning (8-14 days)</span>
          <small class="text-muted">Expiring in 2 weeks</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Caution Level Card -->
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25">
      <div class="card-body p-5">
        <div>
          <span class="icon-shape icon-md bg-primary text-white rounded-2">
            <i class="ti ti-calendar-clock fs-4"></i>
          </span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-2 fw-bold mb-0 d-block">2</span>
          <span class="fs-5">Caution (15-30 days)</span>
          <small class="text-muted">Monitor closely</small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filter Products -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <h2 class="fs-4 mb-4">Filter Products</h2>
        <div class="row g-5">
          <div class="col-lg-7">
            <div class="position-relative">
              <input type="search" class="form-control ps-9" placeholder="Search by product name or SKU">
              <span class="position-absolute top-25 ms-4">
                <i class="ti ti-search text-muted"></i>
              </span>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="d-flex gap-3">
              <select class="form-select">
                <option selected>All Status</option>
                <option value="Expired">Expired</option>
                <option value="Critical">Critical</option>
                <option value="Warning">Warning</option>
                <option value="Caution">Caution</option>
              </select>
              <select class="form-select">
                <option selected>All Categories</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Expired Products Table -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <div>
          <h2 class="fs-4 mb-2">Expired Products</h2>
          <p>Products that have passed their expiry date and need to be removed</p>
        </div>
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light">
              <tr>
                <th class="py-3">Product Name</th>
                <th class="py-3">SKU</th>
                <th class="py-3">Category</th>
                <th class="py-3">Expiry Date</th>
                <th class="py-3">Days Overdue</th>
                <th class="py-3">Quantity</th>
                <th class="py-3">Status</th>
                <th class="py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Wireless Mouse -->
              <tr>
                <td class="py-3">Wireless Mouse</td>
                <td class="py-3">WM-001</td>
                <td class="py-3">Electronics</td>
                <td class="py-3">2025-11-15</td>
                <td class="py-3">47 days</td>
                <td class="py-3">12</td>
                <td class="py-3"><span class="badge bg-danger">Expired</span></td>
                <td class="py-3">
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>

              <!-- USB-C Cable -->
              <tr>
                <td class="py-3">USB-C Cable</td>
                <td class="py-3">UC-002</td>
                <td class="py-3">Accessories</td>
                <td class="py-3">2025-12-01</td>
                <td class="py-3">31 days</td>
                <td class="py-3">8</td>
                <td class="py-3"><span class="badge bg-danger">Expired</span></td>
                <td class="py-3">
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>

              <!-- Keyboard -->
              <tr>
                <td class="py-3">Keyboard</td>
                <td class="py-3">KB-004</td>
                <td class="py-3">Electronics</td>
                <td class="py-3">2025-12-20</td>
                <td class="py-3">12 days</td>
                <td class="py-3">5</td>
                <td class="py-3"><span class="badge bg-danger">Expired</span></td>
                <td class="py-3">
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Near Expiry Products Table -->
<div class="row g-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <div>
          <h2 class="fs-4 mb-2">Near Expiry Products</h2>
          <p>Products approaching their expiry date that may need attention</p>
        </div>
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light">
              <tr>
                <th class="py-3">Product Name</th>
                <th class="py-3">SKU</th>
                <th class="py-3">Category</th>
                <th class="py-3">Expiry Date</th>
                <th class="py-3">Days Remaining</th>
                <th class="py-3">Quantity</th>
                <th class="py-3">Status</th>
                <th class="py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Laptop Stand -->
              <tr>
                <td class="py-3">Laptop Stand</td>
                <td class="py-3">LS-003</td>
                <td class="py-3">Furniture</td>
                <td class="py-3">2026-01-05</td>
                <td class="py-3 text-primary">4 days</td>
                <td class="py-3">15</td>
                <td class="py-3"><span class="badge bg-primary">Critical (≤7 days)</span></td>
                <td class="py-3">
                  <a href="#" class="btn btn-light">Mark For Sale</a>
                </td>
              </tr>

              <!-- Monitor -->
              <tr>
                <td class="py-3">Monitor</td>
                <td class="py-3">MN-005</td>
                <td class="py-3">Electronics</td>
                <td class="py-3">2026-01-08</td>
                <td class="py-3">7 days</td>
                <td class="py-3">10</td>
                <td class="py-3"><span class="badge bg-primary">Critical (≤7 days)</span></td>
                <td class="py-3">
                  <a href="#" class="btn btn-light">Mark For Sale</a>
                </td>
              </tr>

              <!-- Desk Lamp -->
              <tr>
                <td class="py-3">Desk Lamp</td>
                <td class="py-3">DL-006</td>
                <td class="py-3">Furniture</td>
                <td class="py-3">2026-01-12</td>
                <td class="py-3">11 days</td>
                <td class="py-3">20</td>
                <td class="py-3"><span class="badge bg-warning">Warning (8-14 days)</span></td>
                <td class="py-3">
                  <a href="#" class="btn btn-light">Mark For Sale</a>
                </td>
              </tr>

              <!-- Webcam HD -->
              <tr>
                <td class="py-3">Webcam HD</td>
                <td class="py-3">WC-007</td>
                <td class="py-3">Electronics</td>
                <td class="py-3">2026-01-18</td>
                <td class="py-3">17 days</td>
                <td class="py-3">18</td>
                <td class="py-3"><span class="badge bg-warning">Caution (15-30 days)</span></td>
                <td class="py-3">
                  <a href="#" class="btn btn-light">Mark For Sale</a>
                </td>
              </tr>

              <!-- HDMI Cable -->
              <tr>
                <td class="py-3">HDMI Cable</td>
                <td class="py-3">HD-008</td>
                <td class="py-3">Accessories</td>
                <td class="py-3">2026-01-25</td>
                <td class="py-3">24 days</td>
                <td class="py-3">30</td>
                <td class="py-3"><span class="badge bg-warning">Caution (15-30 days)</span></td>
                <td class="py-3">
                  <a href="#" class="btn btn-light">Mark For Sale</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<div class="row">
  <div class="col-12">
    <footer class="text-center py-2 mt-6 text-secondary">
      <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://wyattmatt.github.io/" target="_blank" class="text-primary">WyattMatt</a></p>
    </footer>
  </div>
</div>
@endsection
