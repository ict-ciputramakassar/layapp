@extends('views_backend.layouts.app')

@section('title', 'Product Variants')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Product Variants</h1>
        <p class="mb-0">Manage size, color, and other product attributes</p>
      </div>
      <div>
        <a href="#" class="btn btn-primary">
          <span class="me-1"><i class="ti ti-plus"></i></span>
          <span>Add Variant Type</span>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row g-5 mb-5">
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-info bg-opacity-10 border-info">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Variant Types</span>
            <h2 class="fw-bold mb-0">3</h2>
          </div>
          <div class="icon-shape icon-lg bg-info bg-opacity-10 text-info rounded-2">
            <i class="ti ti-adjustments-horizontal fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-primary bg-opacity-10 border-primary">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Size Options</span>
            <h2 class="fw-bold mb-0">6</h2>
          </div>
          <div class="icon-shape icon-lg bg-primary bg-opacity-10 text-primary rounded-3">
            <i class="ti ti-ruler-2 fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-success bg-opacity-10 border-success">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Color Options</span>
            <h2 class="fw-bold mb-0">7</h2>
          </div>
          <div class="icon-shape icon-lg bg-success bg-opacity-10 text-success rounded-3">
            <i class="ti ti-palette fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card bg-warning bg-opacity-10 border-warning">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Other Attributes</span>
            <h2 class="fw-bold mb-0">8</h2>
          </div>
          <div class="icon-shape icon-lg bg-warning bg-opacity-10 text-warning rounded-3">
            <i class="ti ti-adjustments-share fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Variants Management -->
<div class="row">
  <div class="col-12">
    <div class="card overflow-hidden">
      <div class="card-body p-6">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-3 mb-5">
          <div>
            <h3 class="mb-1 fs-4">Manage Variants</h3>
          </div>
          <div>
            <input type="search" class="form-control" placeholder="Search Variants....">
          </div>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-pills mb-3 bg-light p-2 rounded-2 d-inline-flex overflow-y-auto flex-nowrap text-nowrap" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-sizes-tab" data-bs-toggle="pill" data-bs-target="#pills-sizes" type="button" role="tab" aria-controls="pills-sizes" aria-selected="true">Sizes</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-colors-tab" data-bs-toggle="pill" data-bs-target="#pills-colors" type="button" role="tab" aria-controls="pills-colors" aria-selected="false">Colors</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-otherAttribute-tab" data-bs-toggle="pill" data-bs-target="#pills-otherAttribute" type="button" role="tab" aria-controls="pills-otherAttribute" aria-selected="false">Other Attributes</button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="pills-tabContent">
          <!-- Sizes Tab -->
          <div class="tab-pane fade show active" id="pills-sizes" role="tabpanel" aria-labelledby="pills-sizes-tab" tabindex="0">
            <div class="table-responsive">
              <table class="table mb-0 text-nowrap table-hover table-centered">
                <thead class="table-light border-light">
                  <tr>
                    <th>Size Name</th>
                    <th>Code</th>
                    <th>Products Using</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3">Extra Small</td>
                    <td class="py-3">XS</td>
                    <td class="py-3">14</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Small</td>
                    <td class="py-3">SM</td>
                    <td class="py-3">25</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Medium</td>
                    <td class="py-3">MD</td>
                    <td class="py-3">30</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Large</td>
                    <td class="py-3">LG</td>
                    <td class="py-3">20</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Extra Large</td>
                    <td class="py-3">XL</td>
                    <td class="py-3">56</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Colors Tab -->
          <div class="tab-pane fade" id="pills-colors" role="tabpanel" aria-labelledby="pills-colors-tab" tabindex="0">
            <div class="table-responsive">
              <table class="table mb-0 text-nowrap table-hover table-centered">
                <thead class="table-light border-light">
                  <tr>
                    <th>Color</th>
                    <th>Preview</th>
                    <th>Hex Code</th>
                    <th>Products Using</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3">Black</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs bg-dark rounded-circle"></span>
                    </td>
                    <td class="py-3">#000000</td>
                    <td class="py-3">220</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">White</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs bg-white border rounded-circle"></span>
                    </td>
                    <td class="py-3">#FFFFFF</td>
                    <td class="py-3">185</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Red</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs bg-danger rounded-circle"></span>
                    </td>
                    <td class="py-3">#EF4444</td>
                    <td class="py-3">78</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Blue</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs rounded-circle" style="background-color: #3B82F6;"></span>
                    </td>
                    <td class="py-3">#3B82F6</td>
                    <td class="py-3">95</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Green</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs bg-success rounded-circle"></span>
                    </td>
                    <td class="py-3">#22C55E</td>
                    <td class="py-3">62</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3">Yellow</td>
                    <td class="py-3">
                      <span class="icon-shape icon-xs bg-warning rounded-circle"></span>
                    </td>
                    <td class="py-3">#EAB308</td>
                    <td class="py-3">45</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Other Attributes Tab -->
          <div class="tab-pane fade" id="pills-otherAttribute" role="tabpanel" aria-labelledby="pills-otherAttribute-tab" tabindex="0">
            <div class="table-responsive">
              <table class="table mb-0 text-nowrap table-hover table-centered">
                <thead class="table-light border-light">
                  <tr>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Products Using</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Material</span></td>
                    <td class="py-3">Cotton</td>
                    <td class="py-3">150</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Material</span></td>
                    <td class="py-3">Polyester</td>
                    <td class="py-3">85</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Material</span></td>
                    <td class="py-3">Leather</td>
                    <td class="py-3">42</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Storage</span></td>
                    <td class="py-3">128GB</td>
                    <td class="py-3">92</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Storage</span></td>
                    <td class="py-3">256GB</td>
                    <td class="py-3">65</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">Storage</span></td>
                    <td class="py-3">512GB</td>
                    <td class="py-3">48</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">RAM</span></td>
                    <td class="py-3">8GB</td>
                    <td class="py-3">75</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                      <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td class="py-3"><span class="badge bg-light text-secondary px-3 py-2 rounded-pill">RAM</span></td>
                    <td class="py-3">16GB</td>
                    <td class="py-3">110</td>
                    <td class="py-3">
                      <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
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
