@extends('views_backend.layouts.app')

@section('title', 'Warehouse Location Management')

@section('content')
<!-- Page Title -->
<div class="row">
  <div class="col-12">
    <div class="mb-6 d-flex align-items-center justify-content-between">
      <div>
        <h1 class="fs-3 mb-1">Warehouse / Location Management</h1>
        <p class="mb-0">Manage your warehouses, storage locations, and capacity.</p>
      </div>
      <div>
        <a href="#!" class="btn btn-secondary">Add Warehouse</a>
      </div>
    </div>
  </div>
</div>
<!-- Status Cards -->
<div class="row mb-5 g-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-0">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap">
          <!-- Total Warehouses Card -->
          <div class="p-6 flex-grow-1 d-flex justify-content-between">
            <div class="d-flex flex-column">
              <span class="fs-2 fw-bold mb-3 d-block">5</span>
              <span class="fs-5">Total Warehouses</span>
              <small class="text-info">Across 5 locations</small>
            </div>
            <div>
              <span class="text-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21v-13l9 -4l9 4v13" /><path d="M13 13h4v8h-10v-6h6" /><path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" /></svg>
              </span>
            </div>
          </div>

          <!-- Total Capacity Card -->
          <div class="p-6 flex-grow-1 d-flex justify-content-between">
            <div class="d-flex flex-column">
              <span class="fs-2 fw-bold mb-3 d-block">41,000</span>
              <span class="fs-5">Total Capacity</span>
              <small class="text-warning">Storage units available</small>
            </div>
            <div>
              <span class="text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21h9" /><path d="M9 8h1" /><path d="M9 12h1" /><path d="M9 16h1" /><path d="M14 8h1" /><path d="M14 12h1" /><path d="M5 21v-16c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h10c.53 0 1.039 .211 1.414 .586c.375 .375 .586 .884 .586 1.414v7" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
              </span>
            </div>
          </div>

          <!-- Space Used Card -->
          <div class="p-6 flex-grow-1 d-flex justify-content-between">
            <div class="d-flex flex-column">
              <span class="fs-2 fw-bold mb-3 d-block">25,500</span>
              <span class="fs-5">Space Used</span>
              <small class="text-success">Storage units available</small>
            </div>
            <div>
              <span class="text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-package"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
              </span>
            </div>
          </div>

          <!-- Total Products Card -->
          <div class="p-6 flex-grow-1 d-flex justify-content-between">
            <div class="d-flex flex-column">
              <span class="fs-2 fw-bold mb-3 d-block">730</span>
              <span class="fs-5">Total Products</span>
              <small class="text-primary">Products stored</small>
            </div>
            <div>
              <span class="text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" /></svg>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Search/Filter Section -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <div class="row gx-5">
          <div class="col-lg-12">
            <div class="position-relative">
              <input type="search" class="form-control ps-9" placeholder="Search by product name or SKU">
              <span class="position-absolute top-25 ms-4">
                <i class="ti ti-search text-muted"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Warehouses Table -->
<div class="row g-5 mb-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <div>
          <h2 class="fs-4 mb-2">Warehouses</h2>
          <p>All warehouse facilities and their current status</p>
        </div>
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light">
              <tr>
                <th class="py-3">Warehouse Name</th>
                <th class="py-3">Location</th>
                <th class="py-3">Manager</th>
                <th class="py-3">Capacity</th>
                <th class="py-3">Products</th>
                <th class="py-3">Status</th>
                <th class="py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Main Warehouse -->
              <tr>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3">123 Industrial Ave, New York, NY 10001</td>
                <td class="py-3">John Smith</td>
                <td class="py-3">
                  <div class="small d-flex justify-content-between text-muted">
                    <span>7,500 / 10,000</span>
                    <span>75%</span>
                  </div>
                  <div class="progress-stacked" style="height: 8px;">
                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                      <div class="progress-bar bg-info"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                      <div class="progress-bar"></div>
                    </div>
                  </div>
                </td>
                <td class="py-3 ps-6">245</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- East Distribution Center -->
              <tr>
                <td class="py-3">East Distribution Center</td>
                <td class="py-3">456 Commerce Blvd, Boston, MA 02101</td>
                <td class="py-3">Sarah Johnson</td>
                <td class="py-3">
                  <div class="small d-flex justify-content-between text-muted">
                    <span>6,200 / 8,000</span>
                    <span>78%</span>
                  </div>
                  <div class="progress-stacked" style="height: 8px;">
                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                      <div class="progress-bar bg-info"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                      <div class="progress-bar"></div>
                    </div>
                  </div>
                </td>
                <td class="py-3 ps-6">245</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- West Storage Facility -->
              <tr>
                <td class="py-3">West Storage Facility</td>
                <td class="py-3">789 Logistics Dr, Los Angeles, CA 90001</td>
                <td class="py-3">Mike Davis</td>
                <td class="py-3">
                  <div class="small d-flex justify-content-between text-muted">
                    <span>4,800 / 12,000</span>
                    <span>48%</span>
                  </div>
                  <div class="progress-stacked" style="height: 8px;">
                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 78%">
                      <div class="progress-bar bg-info"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 22%">
                      <div class="progress-bar bg-success"></div>
                    </div>
                  </div>
                </td>
                <td class="py-3 ps-6">156</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- South Hub -->
              <tr>
                <td class="py-3">South Hub</td>
                <td class="py-3">321 Supply St, Miami, FL 33101</td>
                <td class="py-3">Emily Brown</td>
                <td class="py-3">
                  <div class="small d-flex justify-content-between text-muted">
                    <span>5,800 / 6,000</span>
                    <span>97%</span>
                  </div>
                  <div class="progress-stacked" style="height: 8px;">
                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 97%">
                      <div class="progress-bar bg-info"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 3%">
                      <div class="progress-bar bg-primary"></div>
                    </div>
                  </div>
                </td>
                <td class="py-3 ps-6">98</td>
                <td class="py-3"><span class="badge bg-primary">Near Capacity</span></td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- Overflow Storage -->
              <tr>
                <td class="py-3">Overflow Storage</td>
                <td class="py-3">555 Reserve Rd, Chicago, IL 60601</td>
                <td class="py-3">Tom Wilson</td>
                <td class="py-3">
                  <div class="small d-flex justify-content-between text-muted">
                    <span>1,200 / 5,000</span>
                    <span>24%</span>
                  </div>
                  <div class="progress-stacked" style="height: 8px;">
                    <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 76%">
                      <div class="progress-bar bg-info"></div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 24%">
                      <div class="progress-bar bg-success"></div>
                    </div>
                  </div>
                </td>
                <td class="py-3 ps-6">42</td>
                <td class="py-3"><span class="badge bg-success">Active</span></td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Storage Locations Table -->
<div class="row g-5">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-5">
        <div>
          <h2 class="fs-4 mb-2">Storage Locations</h2>
          <p>Zones, aisles, and rack assignments</p>
        </div>
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light">
              <tr>
                <th class="py-3">Warehouse</th>
                <th class="py-3">Zone</th>
                <th class="py-3">Aisle Range</th>
                <th class="py-3">Rack Range</th>
                <th class="py-3">Items Stored</th>
                <th class="py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Main Warehouse Zone A -->
              <tr>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3">
                  <span class="badge bg-secondary bg-opacity-10 rounded-pill text-muted">Zone A</span>
                </td>
                <td class="py-3">A1-A10</td>
                <td class="py-3">R1-R50</td>
                <td class="py-3">1,250</td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- Main Warehouse Zone B -->
              <tr>
                <td class="py-3">Main Warehouse</td>
                <td class="py-3">
                  <span class="badge bg-secondary bg-opacity-10 rounded-pill text-muted">Zone B</span>
                </td>
                <td class="py-3">B1-B8</td>
                <td class="py-3">R1-R40</td>
                <td class="py-3">980</td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- East Distribution Center Zone 1 -->
              <tr>
                <td class="py-3">East Distribution Center</td>
                <td class="py-3">
                  <span class="badge bg-secondary bg-opacity-10 rounded-pill text-muted">Zone 1</span>
                </td>
                <td class="py-3">1A-1F</td>
                <td class="py-3">R1-R30</td>
                <td class="py-3">750</td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- West Storage Facility Section North -->
              <tr>
                <td class="py-3">West Storage Facility</td>
                <td class="py-3">
                  <span class="badge bg-secondary bg-opacity-10 rounded-pill text-muted">Section North</span>
                </td>
                <td class="py-3">N1-N12</td>
                <td class="py-3">R1-R60</td>
                <td class="py-3">1,100</td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
                </td>
              </tr>

              <!-- South Hub Primary -->
              <tr>
                <td class="py-3">South Hub</td>
                <td class="py-3">
                  <span class="badge bg-secondary bg-opacity-10 rounded-pill text-muted">Primary</span>
                </td>
                <td class="py-3">P1-P6</td>
                <td class="py-3">R1-R25</td>
                <td class="py-3">420</td>
                <td class="py-3">
                  <a href="#"><i class="ti ti-edit"></i></a>
                  <a href="#" class="link-danger"><i class="ti ti-trash ms-2"></i></a>
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
