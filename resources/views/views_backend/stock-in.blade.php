@extends('views_backend.layouts.app')

@section('title', 'Stock In / Add Stock')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6">
      <h1 class="fs-3 mb-0">Stock In / Add Stock</h1>
    </div>
  </div>
</div>

<!-- Add Stock Form Card -->
<div class="row g">
  <div class="col-lg-12 col-12">
    <div class="card">
      <div class="card-body p-5">
        <h2 class="fs-5 mb-4">Add Stock</h2>
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

          <!-- Supplier -->
          <div class="mb-3 col-lg-6">
            <label for="supplier" class="form-label">Supplier</label>
            <input type="text" class="form-control" id="supplier" placeholder="Enter supplier name">
          </div>

          <!-- Notes / Description -->
          <div class="mb-3 col-lg-12">
            <label for="notes" class="form-label">Notes / Description</label>
            <textarea class="form-control" id="notes" rows="3" placeholder="Enter any notes"></textarea>
          </div>

          <!-- Submit Button -->
          <div class="mb-3 col-lg-12">
            <button type="submit" class="btn btn-primary">Add Stock</button>
          </div>
        </form>
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
