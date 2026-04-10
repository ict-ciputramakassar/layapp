@extends('views_backend.layouts.app')

@section('title', 'Order List')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6 d-flex align-items-center justify-content-between">
      <div>
        <h1 class="fs-3 mb-1">Order List</h1>
        <p class="mb-0">Manage and track all customer orders</p>
      </div>
      <div>
        <a href="#!" class="btn btn-secondary">Add Order</a>
      </div>
    </div>
  </div>
</div>

<!-- Order Statistics Cards -->
<div class="row mb-5 g-5">
  <!-- Total Orders Card -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-5">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-shape icon-md bg-primary bg-opacity-10 rounded-circle text-primary me-3">
            <i class="ti ti-shopping-cart fs-4"></i>
          </div>
          <div>
            <h2 class="mb-0 fs-3 fw-bold">1,250</h2>
            <p class="mb-0 text-muted">Total Orders</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Orders Card -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-5">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-shape icon-md bg-primary bg-opacity-10 rounded-circle text-primary me-3">
            <i class="ti ti-clock fs-4"></i>
          </div>
          <div>
            <h2 class="mb-0 fs-3 fw-semibold">50</h2>
            <p class="mb-0 text-muted">Pending Orders</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delivered Card -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-5">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-shape icon-md bg-primary bg-opacity-10 rounded-circle text-primary me-3">
            <i class="ti ti-circle-check fs-4"></i>
          </div>
          <div>
            <h2 class="mb-0 fs-3 fw-semibold">600</h2>
            <p class="mb-0 text-muted">Delivered</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Revenue Card -->
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-5">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-shape icon-md bg-primary bg-opacity-10 rounded-circle text-primary me-3">
            <i class="ti ti-file-dollar fs-4"></i>
          </div>
          <div>
            <h2 class="mb-0 fs-3 fw-semibold">$993.84</h2>
            <p class="mb-0 text-muted">Total Revenue</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Search and Filter Section -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
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
                <option selected="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Orders Table -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light">
              <tr>
                <th class="py-3">Order #</th>
                <th class="py-3">Customer</th>
                <th class="py-3">Date</th>
                <th class="py-3">Items</th>
                <th class="py-3">Status</th>
                <th class="py-3">Payment</th>
                <th class="py-3">Total</th>
                <th class="py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Order 1 -->
              <tr>
                <td class="py-3">ORD-001</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>John Smith</span>
                    <span>john@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-15</td>
                <td class="py-3">2 items</td>
                <td class="py-3"><span class="badge bg-success">Delivered</span></td>
                <td class="py-3"><span class="badge bg-success">Paid</span></td>
                <td class="py-3">$98.95</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
                </td>
              </tr>

              <!-- Order 2 -->
              <tr>
                <td class="py-3">ORD-002</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>Jane Doe</span>
                    <span>jane@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-16</td>
                <td class="py-3">2 items</td>
                <td class="py-3"><span class="badge bg-info">Shipped</span></td>
                <td class="py-3"><span class="badge bg-success">Paid</span></td>
                <td class="py-3">$129.00</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
                </td>
              </tr>

              <!-- Order 3 -->
              <tr>
                <td class="py-3">ORD-003</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>Mike Wilson</span>
                    <span>mike@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-13</td>
                <td class="py-3">1 item</td>
                <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-dark">Processing</span></td>
                <td class="py-3"><span class="badge bg-success">Paid</span></td>
                <td class="py-3">$599.98</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
                </td>
              </tr>

              <!-- Order 4 -->
              <tr>
                <td class="py-3">ORD-004</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>Emily Brown</span>
                    <span>emily@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-12</td>
                <td class="py-3">2 items</td>
                <td class="py-3"><span class="badge bg-warning">Pending</span></td>
                <td class="py-3"><span class="badge bg-warning">Pending</span></td>
                <td class="py-3">$169.95</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
                </td>
              </tr>

              <!-- Order 5 -->
              <tr>
                <td class="py-3">ORD-005</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>David Lee</span>
                    <span>david@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-11</td>
                <td class="py-3">1 item</td>
                <td class="py-3"><span class="badge bg-danger">Cancelled</span></td>
                <td class="py-3"><span class="badge bg-secondary bg-opacity-10 text-dark">Refunded</span></td>
                <td class="py-3">$159.98</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
                </td>
              </tr>

              <!-- Order 6 -->
              <tr>
                <td class="py-3">ORD-006</td>
                <td class="py-3">
                  <div class="small d-flex flex-column">
                    <span>Lisa Anderson</span>
                    <span>lisa@example.com</span>
                  </div>
                </td>
                <td class="py-3">2024-01-10</td>
                <td class="py-3">2 items</td>
                <td class="py-3"><span class="badge bg-success">Delivered</span></td>
                <td class="py-3"><span class="badge bg-success">Paid</span></td>
                <td class="py-3">$164.93</td>
                <td class="py-3">
                  <a class="btn btn-light btn-sm" href="/order-details">View</a>
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
