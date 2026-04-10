@extends('views_backend.layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Product Categories</h1>
        <p class="mb-0">Manage your product categories</p>
      </div>
      <div>
        <a href="#" class="btn btn-primary">
          <span class="me-1"><i class="ti ti-plus"></i></span>
          <span>Add Categories</span>
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
        <div class="d-flex align-items-start gap-3">
          <div class="icon-shape icon-lg bg-primary bg-opacity-10 text-primary rounded-2">
            <i class="ti ti-category fs-4"></i>
          </div>
          <div>
            <span>Total Categories</span>
            <h2 class="fw-bold mb-0">6</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3">
          <div class="icon-shape icon-lg bg-info bg-opacity-10 text-info rounded-2">
            <i class="ti ti-check fs-4"></i>
          </div>
          <div>
            <span>Active</span>
            <h2 class="fw-bold mb-0">5</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3">
          <div class="icon-shape icon-lg bg-warning bg-opacity-10 text-warning rounded-2">
            <i class="ti ti-x fs-4"></i>
          </div>
          <div>
            <span>Inactive</span>
            <h2 class="fw-bold mb-0">1</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="card">
      <div class="card-body p-6">
        <div class="d-flex align-items-start gap-3">
          <div class="icon-shape icon-lg bg-warning bg-opacity-10 text-warning rounded-2">
            <i class="ti ti-box-seam fs-4"></i>
          </div>
          <div>
            <span>Total Products</span>
            <h2 class="fw-bold mb-0">356</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Categories Table -->
<div class="row">
  <div class="col-12">
    <div class="card overflow-hidden">
      <div class="card-body p-6">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-3 mb-5">
          <div>
            <h3 class="mb-1 fs-4">Product Categories</h3>
            <p class="mb-0">List of all product categories</p>
          </div>
          <div>
            <input type="search" class="form-control" placeholder="Search Categories....">
          </div>
        </div>

        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light border-light">
              <tr>
                <th>Category</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Products</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-3">Laptop</td>
                <td class="py-3">laptop</td>
                <td class="py-3">All types of laptops</td>
                <td class="py-3">45</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">2024-01-10</td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Desktop</td>
                <td class="py-3">desktop</td>
                <td class="py-3">Desktop computers and workstations</td>
                <td class="py-3">32</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">2024-01-12</td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Phone</td>
                <td class="py-3">phone</td>
                <td class="py-3">Mobile phones and smartphones</td>
                <td class="py-3">78</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">2024-01-18</td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Tablet</td>
                <td class="py-3">tablet</td>
                <td class="py-3">Tablets and mobile devices</td>
                <td class="py-3">25</td>
                <td class="py-3"><span class="badge bg-secondary">Inactive</span></td>
                <td class="py-3">2024-01-18</td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
              <tr>
                <td class="py-3">Audio</td>
                <td class="py-3">audio</td>
                <td class="py-3">Headphones, speakers, and audio equipment</td>
                <td class="py-3">56</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">2024-01-18</td>
                <td class="py-3">
                  <a href="#" class=""><i class="ti ti-edit fs-5"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2 fs-5"></i></a>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td class="border-bottom-0">Showing product per page</td>
                <td colspan="9" class="border-bottom-0">
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
