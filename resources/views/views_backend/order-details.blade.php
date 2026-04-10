@extends('views_backend.layouts.app')

@section('title', 'Order Details')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6 d-flex align-items-center justify-content-between">
      <div>
        <h1 class="fs-3 mb-1">Order ORD-001</h1>
        <p class="mb-0">View and manage order details</p>
      </div>
      <div class="d-flex align-items-center gap-1">
        <span class="badge bg-success">Delivered</span>
        <span class="badge bg-success">Paid</span>
      </div>
    </div>
  </div>
</div>

<!-- Order Details Content -->
<div class="row g-6">
  <!-- Main Content (Left Side) -->
  <div class="col-lg-8">
    <!-- Order Items Table -->
    <div class="card">
      <div class="card-body">
        <h2 class="fs-4">Order Items</h2>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Wireless Mouse</td>
                <td>WM-12345</td>
                <td>2</td>
                <td>$29.99</td>
                <td>$59.98</td>
              </tr>
              <tr>
                <td>Bluetooth Keyboard</td>
                <td>BK-67890</td>
                <td>1</td>
                <td>$12.99</td>
                <td>$38.97</td>
              </tr>
            </tbody>
            <tfoot class="border-top">
              <tr>
                <td colspan="4" class="text-muted border-bottom-0">Subtotal</td>
                <td class="border-bottom-0">$98.95</td>
              </tr>
              <tr>
                <td colspan="4" class="text-muted border-bottom-0">Shipping</td>
                <td class="border-bottom-0">$9.99</td>
              </tr>
              <tr>
                <td colspan="4" class="text-muted">Tax</td>
                <td>$8.92</td>
              </tr>
              <tr>
                <td colspan="4" class="fw-semibold">Total</td>
                <td>$127.86</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <!-- Shipping Information -->
    <div class="card mt-4">
      <div class="card-body">
        <h2 class="fs-4 mb-4">Shipping Information</h2>
        <p class="mb-0">
          <span class="text-muted">Tracking Number:</span>
          <span class="fw-semibold">1Z999AA10123456784</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Sidebar (Right Side) -->
  <div class="col-lg-4">
    <!-- Customer Information -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="fs-4 mb-4">Customer Information</h2>
        <p class="mb-3">
          <span class="text-muted me-1"><i class="ti ti-user"></i></span>
          <span class="fw-semibold">John Doe</span>
        </p>
        <p class="mb-3">
          <span class="text-muted me-1"><i class="ti ti-mail"></i></span>
          <span class="fw-semibold">john.doe@example.com</span>
        </p>
        <p class="mb-0">
          <span class="text-muted me-1"><i class="ti ti-phone"></i></span>
          <span class="fw-semibold">+1 234 567 8901</span>
        </p>
      </div>
    </div>

    <!-- Shipping Address -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="fs-4 mb-4">Shipping Address</h2>
        <p class="mb-0 d-flex gap-2">
          <i class="ti ti-map-pin mt-1"></i>
          <span>123 Main St, Apt 4B,<br>
          Springfield, IL 62704,<br>
          USA</span>
        </p>
      </div>
    </div>

    <!-- Payment Information -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="fs-4 mb-4">Payment Information</h2>
        <p class="mb-3">
          <span class="text-muted me-1"><i class="ti ti-credit-card"></i></span>
          <span class="fw-semibold">Credit Card</span>
        </p>
        <p class="mb-0">
          <span class="text-muted me-1"><i class="ti ti-file-invoice"></i></span>
          <span class="fw-semibold">INV-1001</span>
        </p>
      </div>
    </div>

    <!-- Order Notes -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="fs-4 mb-4">Order Notes</h2>
        <p class="mb-0">Please deliver between 9 AM and 5 PM. Leave the package at the front door if no one is home.</p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<div class="row">
  <div class="col-12">
    <footer class="text-center py-2 mt-6 text-secondary">
      <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://codescandy.com/" target="_blank" class="text-primary">CodesCandy</a></p>
    </footer>
  </div>
</div>
@endsection
