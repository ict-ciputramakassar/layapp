@extends('views_backend.layouts.app')

@section('title', 'Product Brands')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Brands / Manufacturers</h1>
        <p class="mb-0">Manage product brands and manufacturers</p>
      </div>
      <div>
        <a href="#" class="btn btn-primary">
          <span class="me-1"><i class="ti ti-plus"></i></span>
          <span>Add Brand</span>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row g-5 mb-5">
  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Total Brands</span>
            <h2 class="fw-bold mb-0">7</h2>
          </div>
          <div class="icon-shape icon-lg bg-secondary bg-opacity-10 text-secondary rounded-circle">
            <i class="ti ti-building fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Active</span>
            <h2 class="fw-bold mb-0">6</h2>
          </div>
          <div class="icon-shape icon-lg bg-secondary bg-opacity-10 text-secondary rounded-circle">
            <i class="ti ti-check fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Inactive</span>
            <h2 class="fw-bold mb-0">1</h2>
          </div>
          <div class="icon-shape icon-lg bg-secondary bg-opacity-10 text-secondary rounded-circle">
            <i class="ti ti-x fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3 justify-content-between">
          <div>
            <span>Total Products</span>
            <h2 class="fw-bold mb-0">450</h2>
          </div>
          <div class="icon-shape icon-lg bg-secondary bg-opacity-10 text-secondary rounded-circle">
            <i class="ti ti-box-seam fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Brands Table -->
<div class="row">
  <div class="col-12">
    <div class="card overflow-hidden">
      <div class="card-body p-6">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-3 mb-5">
          <div>
            <h3 class="mb-1 fs-4">Brands List</h3>
            <p class="mb-0">List of all product brands</p>
          </div>
          <div>
            <input type="search" class="form-control" placeholder="Search Brands....">
          </div>
        </div>

        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light border-light">
              <tr>
                <th>Brand</th>
                <th>Description</th>
                <th>Website</th>
                <th>Products</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-3">Apple</td>
                <td class="py-3">Premium electronics and devices</td>
                <td class="py-3">apple.com</td>
                <td class="py-3">85</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Lenovo</td>
                <td class="py-3">Computers and laptops</td>
                <td class="py-3">lenovo.com</td>
                <td class="py-3">62</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Samsung</td>
                <td class="py-3">Electronics and appliances</td>
                <td class="py-3">samsung.com</td>
                <td class="py-3">120</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Dell</td>
                <td class="py-3">Computer technology company</td>
                <td class="py-3">dell.com</td>
                <td class="py-3">45</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">HP</td>
                <td class="py-3">Computing and printing</td>
                <td class="py-3">hp.com</td>
                <td class="py-3">58</td>
                <td class="py-3"><span class="badge bg-secondary">Inactive</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Sony</td>
                <td class="py-3">Entertainment and electronics</td>
                <td class="py-3">sony.com</td>
                <td class="py-3">38</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">LG</td>
                <td class="py-3">Electronics and home appliances</td>
                <td class="py-3">lg.com</td>
                <td class="py-3">42</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td class="border-top">Showing product per page</td>
                <td colspan="9" class="border-top">
                  <nav aria-label="Page navigation" class="d-flex justify-content-end">
                    <ul class="pagination mb-0">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
                </td>
              </tr>
            </tfoot>
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
