@extends('views_backend.layouts.app')

@section('title', 'Stock Out / Remove')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6">
      <h1 class="fs-3 mb-0">Stock Out / Remove Stock</h1>
    </div>
  </div>
</div>

<!-- Remove Stock Form Card -->
<div class="row mb-5">
  <div class="col-lg-12 col-12">
    <div class="card">
      <div class="card-body p-5">
        <h2 class="fs-5 mb-4">Remove Stock</h2>
        <form class="row gx-5">
          <!-- Product Name -->
          <div class="mb-3 col-lg-6">
            <label for="productName" class="form-label">Product</label>
            <select name="product" id="productName" class="form-select">
              <option value="">Select a product</option>
              <option value="productA">Product A</option>
              <option value="productB">Product B</option>
              <option value="productC">Product C</option>
            </select>
          </div>

          <!-- Quantity -->
          <div class="mb-3 col-lg-6">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" placeholder="Enter quantity">
          </div>

          <!-- Warehouse -->
          <div class="mb-3 col-lg-6">
            <label for="warehouse" class="form-label">Warehouse</label>
            <select name="warehouse" id="warehouse" class="form-select">
              <option value="">Select a warehouse</option>
              <option value="warehouse1">Warehouse 1</option>
              <option value="warehouse2">Warehouse 2</option>
              <option value="warehouse3">Warehouse 3</option>
            </select>
          </div>

          <!-- Reason -->
          <div class="mb-3 col-lg-6">
            <label for="reason" class="form-label">Reason</label>
            <select name="reason" id="reason" class="form-select">
              <option value="">Select a reason</option>
              <option value="damaged">Damaged</option>
              <option value="expired">Expired</option>
              <option value="lost">Lost</option>
            </select>
          </div>

          <!-- Notes / Description -->
          <div class="mb-3 col-lg-12">
            <label for="notes" class="form-label">Notes / Description</label>
            <textarea class="form-control" id="notes" rows="3" placeholder="Enter any notes"></textarea>
          </div>

          <!-- Submit Button -->
          <div class="mb-3 col-lg-12">
            <button type="submit" class="btn btn-primary">Remove Stock</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Recent Stock Removals -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <h3 class="fs-5">Recent Stock Removals</h3>

        <!-- Removal Item 1 -->
        <div class="border-bottom d-flex justify-content-between align-items-center mb-4 pb-3">
          <div class="d-flex gap-3 align-items-center py-3">
            <div class="icon-shape icon-md bg-danger bg-opacity-10 text-danger rounded-2">
              <i class="ti ti-trending-down"></i>
            </div>
            <div>
              <h5 class="mb-0">Product A</h5>
              <p class="mb-0 small text-secondary">Main Warehouse • Sold</p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-end">
            <span class="fs-5 text-danger">-30</span>
            <span>Today, 10:30 AM</span>
          </div>
        </div>

        <!-- Removal Item 2 -->
        <div class="border-bottom d-flex justify-content-between align-items-center mb-4 pb-3">
          <div class="d-flex gap-3 align-items-center py-3">
            <div class="icon-shape icon-md bg-danger bg-opacity-10 text-danger rounded-2">
              <i class="ti ti-trending-down"></i>
            </div>
            <div>
              <h5 class="mb-0">Product B</h5>
              <p class="mb-0 small text-secondary">Secondary Warehouse • Damaged</p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-end">
            <span class="fs-5 text-danger">-15</span>
            <span>Today, 9:15 AM</span>
          </div>
        </div>

        <!-- Removal Item 3 -->
        <div class="border-bottom d-flex justify-content-between align-items-center mb-4 pb-3">
          <div class="d-flex gap-3 align-items-center py-3">
            <div class="icon-shape icon-md bg-danger bg-opacity-10 text-danger rounded-2">
              <i class="ti ti-trending-down"></i>
            </div>
            <div>
              <h5 class="mb-0">Product C</h5>
              <p class="mb-0 small text-secondary">Main Warehouse • Sold</p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-end">
            <span class="fs-5 text-danger">-50</span>
            <span>Yesterday, 4:00 PM</span>
          </div>
        </div>

        <!-- Removal Item 4 -->
        <div class="d-flex justify-content-between align-items-center pb-3">
          <div class="d-flex gap-3 align-items-center py-3">
            <div class="icon-shape icon-md bg-danger bg-opacity-10 text-danger rounded-2">
              <i class="ti ti-trending-down"></i>
            </div>
            <div>
              <h5 class="mb-0">Product D</h5>
              <p class="mb-0 small text-secondary">Main Warehouse • Expired</p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-end">
            <span class="fs-5 text-danger">-10</span>
            <span>Yesterday, 2:30 PM</span>
          </div>
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
