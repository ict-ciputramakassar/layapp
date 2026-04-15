@extends('views_backend.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Lenovo 3rd Generation</h1>
        <p class="mb-0">SKU: PT001</p>
      </div>
      <div>
        <a href="{{ route('edit-product') }}" class="btn btn-secondary">
          <span class="me-1"><i class="ti ti-edit"></i></span>
          <span>Edit</span>
        </a>
        <a href="#!" class="btn btn-primary">
          <span class="me-1"><i class="ti ti-trash"></i></span>
          <span>Delete</span>
        </a>
      </div>
    </div>
  </div>
</div>

<div>
  <div class="row g-5 mb-5">
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body p-6">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-shape icon-lg bg-info-subtle text-info-emphasis rounded-2">
              <i class="ti ti-box-seam fs-3"></i>
            </div>
            <div class="d-flex flex-column gap-0">
              <span class="text-muted">In Stock</span>
              <span class="fs-4 fw-semibold">100</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body p-6">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-shape icon-lg bg-primary-subtle text-primary-emphasis rounded-2">
              <i class="ti ti-file-dollar fs-3"></i>
            </div>
            <div class="d-flex flex-column gap-0">
              <span class="text-muted">Sale Price</span>
              <span class="fs-4 fw-semibold">$1500</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body p-6">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-shape icon-lg bg-success-subtle text-success-emphasis rounded-2">
              <i class="ti ti-trending-up fs-3"></i>
            </div>
            <div class="d-flex flex-column gap-0">
              <span class="text-muted">Total Sold</span>
              <span class="fs-4 fw-semibold">45</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body p-6">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-shape icon-lg bg-warning-subtle text-warning-emphasis rounded-2">
              <i class="ti ti-chart-histogram fs-3"></i>
            </div>
            <div class="d-flex flex-column gap-0">
              <span class="text-muted">Revenue</span>
              <span class="fs-4 fw-semibold">$67500</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-5">
    <div class="col-lg-8 col-12">
      <div class="card">
        <div class="card-body p-6">
          <h2 class="fs-4 mb-3">Product Details</h2>
          <ul class="nav nav-pills mb-3 bg-light p-2 rounded-2 d-inline-flex" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-information-tab" data-bs-toggle="pill" data-bs-target="#pills-information" type="button" role="tab" aria-controls="pills-information" aria-selected="true">Information</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-variants-tab" data-bs-toggle="pill" data-bs-target="#pills-variants" type="button" role="tab" aria-controls="pills-variants" aria-selected="false">Variants</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-salesHistory-tab" data-bs-toggle="pill" data-bs-target="#pills-salesHistory" type="button" role="tab" aria-controls="pills-salesHistory" aria-selected="false">Sales History</button>
            </li>
          </ul>

          <div class="tab-content mt-3" id="pills-tabContent">
            <!-- Information Tab -->
            <div class="tab-pane fade show active" id="pills-information" role="tabpanel" aria-labelledby="pills-information-tab" tabindex="0">
              <div class="row">
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Category</h5>
                  <p class="mb-0 fw-semibold">Laptop</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Brand</h5>
                  <p class="mb-0 fw-semibold">Lenovo</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Unit</h5>
                  <p class="mb-0 fw-semibold">Piece</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Min Quantity</h5>
                  <p class="mb-0 fw-semibold">10</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Tax</h5>
                  <p class="mb-0 fw-semibold">5%</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Discount</h5>
                  <p class="mb-0 fw-semibold">10%</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Cost Price</h5>
                  <p class="mb-0 fw-semibold">$1200</p>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <h5 class="mb-2 fs-6">Status</h5>
                  <p class="mb-0 fw-semibold">Active</p>
                </div>
                <div class="col-12 mb-3">
                  <h5 class="mb-2 fs-6">Description</h5>
                  <p class="mb-0">High-performance laptop with latest specifications. Features include 16GB RAM, 512GB SSD, and Intel Core i7 processor.</p>
                </div>
              </div>
            </div>

            <!-- Variants Tab -->
            <div class="tab-pane fade" id="pills-variants" role="tabpanel" aria-labelledby="pills-variants-tab" tabindex="0">
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div class="fw-semibold">8GB RAM</div>
                <div class="d-flex gap-2">
                  <span>Stock: 30</span>
                  <span class="fw-semibold">$1300</span>
                </div>
              </div>
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div class="fw-semibold">16GB RAM</div>
                <div class="d-flex gap-2">
                  <span>Stock: 50</span>
                  <span class="fw-semibold">$1500</span>
                </div>
              </div>
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div class="fw-semibold">32GB RAM</div>
                <div class="d-flex gap-2">
                  <span>Stock: 20</span>
                  <span class="fw-semibold">$1800</span>
                </div>
              </div>
            </div>

            <!-- Sales History Tab -->
            <div class="tab-pane fade" id="pills-salesHistory" role="tabpanel" aria-labelledby="pills-salesHistory-tab" tabindex="0">
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div>2024-03-10</div>
                <div class="d-flex gap-2">
                  <span>Qty: 5</span>
                  <span class="fw-semibold">$7500</span>
                </div>
              </div>
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div>2024-03-08</div>
                <div class="d-flex gap-2">
                  <span>Qty: 3</span>
                  <span class="fw-semibold">$4500</span>
                </div>
              </div>
              <div class="d-flex justify-content-between bg-light p-3 rounded-2 mb-2">
                <div>2024-03-05</div>
                <div class="d-flex gap-2">
                  <span>Qty: 8</span>
                  <span class="fw-semibold">$12000</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Images & Timeline -->
    <div class="col-lg-4 col-12">
      <!-- Product Images Card -->
      <div class="card mb-5">
        <div class="card-body p-6">
          <h2 class="fs-4 mb-3">Product Images</h2>
          <form id="my-dropzone" class="dropzone">
            <div class="dz-message" data-dz-message>
              <span>Drop files here to upload</span>
            </div>
          </form>
        </div>
      </div>

      <!-- Timeline Card -->
      <div class="card mb-5">
        <div class="card-body p-6">
          <h2 class="fs-4 mb-3">Timeline</h2>
          <div class="d-flex flex-column mb-3">
            <span>Created</span>
            <span class="fw-semibold">2024-01-15</span>
          </div>
          <div class="d-flex flex-column mb-3">
            <span>Last Updated</span>
            <span class="fw-semibold">2024-03-10</span>
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
</div>
@endsection
