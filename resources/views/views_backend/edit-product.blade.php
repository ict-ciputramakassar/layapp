@extends('views_backend.layouts.app')

@section('title', 'Edit Product - InApp Inventory Dashboard')

@section('content')
<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Edit Event</h1>
        <p class="mb-0">Update event information</p>
      </div>
    </div>
  </div>
</div>

<!-- Content -->
<div class="row g-5">
  <!-- Left Column: Product Details -->
  <div class="col-lg-8 col-12">
    <!-- Product Information Card -->
    <div class="card mb-5">
      <div class="card-body p-6">
        <h2 class="fs-4 mb-3">Event Information</h2>
        <div class="row g-5">
          <div class="col-lg-6">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" id="eventName" class="form-control" placeholder="Enter event name" value="Lenovo 3rd Generation">
          </div>
          <div class="col-lg-6">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" id="sku" class="form-control" placeholder="Enter SKU" value="PT001">
          </div>
          <div class="col-lg-6">
            <label for="category" class="form-label">Category</label>
            <select id="category" class="form-select">
              <option value="Laptop">Laptop</option>
              <option value="Desktop">Desktop</option>
              <option value="Accessories">Accessories</option>
              <option value="Phone">Phone</option>
            </select>
          </div>
          <div class="col-lg-6">
            <label for="brand" class="form-label">Brand</label>
            <select id="brand" class="form-select">
              <option value="Lenovo">Lenovo</option>
              <option value="Apple">Apple</option>
              <option value="Dell">Dell</option>
              <option value="HP">HP</option>
            </select>
          </div>
          <div class="col-lg-12">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" rows="3" class="form-control" placeholder="High-performance laptop with latest specifications."></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Pricing & Stock Card -->
    <div class="card">
      <div class="card-body p-6">
        <h2 class="fs-4 mb-3">Pricing & Stock</h2>
        <div class="row g-5">
          <div class="col-lg-4">
            <label for="productPrice" class="form-label">Price ($)</label>
            <input type="number" id="productPrice" class="form-control" placeholder="0.00" value="1500">
          </div>
          <div class="col-lg-4">
            <label for="productTax" class="form-label">Tax (%)</label>
            <input type="number" id="productTax" class="form-control" placeholder="0" value="5">
          </div>
          <div class="col-lg-4">
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" id="discount" class="form-control" placeholder="0" value="10">
          </div>
          <div class="col-lg-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" class="form-control" placeholder="0" value="100">
          </div>
          <div class="col-lg-4">
            <label for="minQuantity" class="form-label">Minimum Quantity</label>
            <input type="number" id="minQuantity" class="form-control" placeholder="0" value="10">
          </div>
          <div class="col-lg-4">
            <label for="unit" class="form-label">Unit</label>
            <select id="unit" class="form-select">
              <option value="Piece">Piece</option>
              <option value="Kg">Kg</option>
              <option value="Box">Box</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Images & Status -->
  <div class="col-lg-4 col-12">
    <!-- Product Images Card -->
    <div class="card mb-5">
      <div class="card-body p-6">
        <h2 class="fs-4 mb-3">Event Images</h2>
        <div id="my-dropzone" class="dropzone border border-dashed rounded-3">
            <div class="fallback"><input type="file" name="file" required /></div>
        </div>
      </div>
    </div>

    <!-- Status Card -->
    <div class="card mb-5">
      <div class="card-body p-6">
        <h2 class="fs-4 mb-3">Status</h2>
        <div>
          <label for="status" class="form-label">Status</label>
          <select id="status" class="form-select">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Draft">Draft</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-2">
      <a href="{{ route('event-list') }}" class="btn btn-secondary">Cancel</a>
      <a href="{{ route('event-list') }}" class="btn btn-primary">Update Event</a>
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
