@extends('views_backend.layouts.app')

@section('title', 'Low Stock Products')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6 d-flex justify-content-between align-items-center">
      <h1 class="fs-3 mb-0">Low Stock Products</h1>
      <a href="#!" class="btn btn-primary">
        <span><i class="ti ti-plus"></i></span>
        <span>Restock All</span>
      </a>
    </div>
  </div>
</div>

<!-- Stock Status Cards -->
<div class="row mb-5 g-5">
  <!-- Total Low Stock Card -->
  <div class="col-lg-4 col-12">
    <div class="card border border-warning border-opacity-25">
      <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center">
          <span>Total Low Stock</span>
          <span><i class="ti ti-alert-triangle fs-3 text-warning"></i></span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-3 fw-bold mb-0 d-block text-warning">6</span>
          <small class="text-muted">Products need attention</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Critical Level Card -->
  <div class="col-lg-4 col-12">
    <div class="card border border-danger border-opacity-25">
      <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center">
          <span>Critical Level</span>
          <span><i class="ti ti-activity-heartbeat fs-3 text-danger"></i></span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-3 fw-bold mb-0 d-block text-danger">3</span>
          <small class="text-muted">Immediate restock needed</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Warning Level Card -->
  <div class="col-lg-4 col-12">
    <div class="card border border-success border-opacity-25">
      <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center">
          <span>Warning Level</span>
          <span><i class="ti ti-box-seam fs-3 text-success"></i></span>
        </div>
        <div class="d-flex flex-column mt-3">
          <span class="fs-3 fw-bold mb-0 d-block text-success">3</span>
          <small class="text-muted">Restock soon</small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Low Stock Items Table -->
<div class="row g-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <h2 class="mb-4 fs-5">Low Stock Items</h2>
        <div class="table-responsive">
          <table class="table table-hover mb-0 table-centered">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Current Stock</th>
                <th>Min Stock</th>
                <th>Warehouse</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Product A -->
              <tr>
                <td class="py-3">Product A</td>
                <td class="py-3 text-secondary">SKU-001</td>
                <td class="py-3 text-danger">5</td>
                <td class="py-3">20</td>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3"><span class="badge bg-danger rounded-pill">Critical</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
              </tr>

              <!-- Product B -->
              <tr>
                <td class="py-3">Product B</td>
                <td class="py-3 text-secondary">SKU-002</td>
                <td class="py-3 text-warning">12</td>
                <td class="py-3">25</td>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-dark rounded-pill">Warning</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
              </tr>

              <!-- Product C -->
              <tr>
                <td class="py-3">Product C</td>
                <td class="py-3 text-secondary">SKU-003</td>
                <td class="py-3 text-danger">3</td>
                <td class="py-3">15</td>
                <td class="py-3">Secondary Warehouse</td>
                <td class="py-3"><span class="badge bg-danger rounded-pill">Critical</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
              </tr>

              <!-- Product D -->
              <tr>
                <td class="py-3">Product D</td>
                <td class="py-3 text-secondary">SKU-004</td>
                <td class="py-3 text-warning">18</td>
                <td class="py-3">30</td>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-dark rounded-pill">Warning</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
              </tr>

              <!-- Product E -->
              <tr>
                <td class="py-3">Product E</td>
                <td class="py-3 text-secondary">SKU-005</td>
                <td class="py-3 text-danger">2</td>
                <td class="py-3">10</td>
                <td class="py-3">Secondary Warehouse</td>
                <td class="py-3"><span class="badge bg-danger rounded-pill">Critical</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
              </tr>

              <!-- Product F -->
              <tr>
                <td class="py-3">Product F</td>
                <td class="py-3 text-secondary">SKU-006</td>
                <td class="py-3 text-warning">8</td>
                <td class="py-3">20</td>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-dark rounded-pill">Warning</span></td>
                <td class="py-3"><a href="#!" class="btn btn-sm btn-secondary">Restock</a></td>
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
