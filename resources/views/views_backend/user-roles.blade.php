@extends('views_backend.layouts.app')

@section('title', 'User Roles')

@section('content')
  <!-- Page Title -->
  <div class="row">
    <div class="col-12">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
          <h1 class="fs-3 mb-1">User Roles</h1>
          <p class="mb-0">Manage users and their permissions</p>
        </div>
        <div>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetUserForm()">
            <i class="ti ti-plus"></i> Add User
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Grid -->
  <div class="row g-4">
    <!-- Users Table -->
    <div class="col-lg-8">
      <div class="card overflow-hidden p-6">
        <div class="table-responsive">
          <table class="table mb-0 text-nowrap table-hover table-centered">
            <thead class="table-light border-light">
              <tr style="font-size: 0.875rem;">
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="userTable">
              <tr>
                <td colspan="4" class="text-center">Loading...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Role Permissions -->
    <div class="col-lg-4">
      <div class="card border">
        <div class="card-body p-6">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Available Roles</h5>
            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal">
              <i class="ti ti-plus"></i> Add Role
            </button>
          </div>
          <div id="rolesList" class="d-flex flex-column gap-2">
            <div class="p-4 bg-light rounded-2 border mb-2">
              <h6 class="mb-1">Loading roles...</h6>
              <p class="text-muted small mb-0">Fetching from database</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add / Edit User Modal -->
  <div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalTitle">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input id="name" type="text" class="form-control" placeholder="Full Name" />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input id="email" type="email" class="form-control" placeholder="Email" />
          </div>
          <div class="mb-3 phone-field">
            <label class="form-label">Phone Number</label>
            <input id="phone" type="text" class="form-control" placeholder="Phone Number" />
          </div>
          <div class="mb-3 password-field" style="display: none;">
            <label class="form-label">Password</label>
            <input id="password" type="password" class="form-control" placeholder="Password" />
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select id="role" class="form-select">
              <option value="">Select a role...</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark" onclick="saveUser()">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add / Edit Role Modal -->
  <div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="roleModalTitle">Add Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input id="roleName" type="text" class="form-control" placeholder="e.g., Manager" />
          </div>
          <div class="mb-3">
            <label class="form-label">Role Code</label>
            <input id="roleCode" type="text" class="form-control" placeholder="e.g., MGR" maxlength="3" />
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Permissions</label>
            <div class="border rounded p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_dashboard" />
                <label class="form-check-label" for="perm_dashboard">Dashboard</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_inventory" />
                <label class="form-check-label" for="perm_inventory">Inventory</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_reports" />
                <label class="form-check-label" for="perm_reports">Reports</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_create_event" />
                <label class="form-check-label" for="perm_create_event">Add Event</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_edit_product" />
                <label class="form-check-label" for="perm_edit_product">Edit Product</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_product_details" />
                <label class="form-check-label" for="perm_product_details">Product Details</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_categories" />
                <label class="form-check-label" for="perm_categories">Categories</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_brands" />
                <label class="form-check-label" for="perm_brands">Brands</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_variants" />
                <label class="form-check-label" for="perm_variants">Variants</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_stock_overview" />
                <label class="form-check-label" for="perm_stock_overview">Stock Overview</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_stock_in" />
                <label class="form-check-label" for="perm_stock_in">Stock In</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_stock_out" />
                <label class="form-check-label" for="perm_stock_out">Stock Out</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_low_stock" />
                <label class="form-check-label" for="perm_low_stock">Low Stock Products</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_expired_stock" />
                <label class="form-check-label" for="perm_expired_stock">Expired Stock</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_warehouse" />
                <label class="form-check-label" for="perm_warehouse">Warehouse Location</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_order_list" />
                <label class="form-check-label" for="perm_order_list">Order List</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_order_details" />
                <label class="form-check-label" for="perm_order_details">Order Details</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_create_order" />
                <label class="form-check-label" for="perm_create_order">Create Order</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_invoice" />
                <label class="form-check-label" for="perm_invoice">Invoice</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_returns" />
                <label class="form-check-label" for="perm_returns">Returns / Refunds</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_pos" />
                <label class="form-check-label" for="perm_pos">POS</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_user_roles" />
                <label class="form-check-label" for="perm_user_roles">User Roles</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_docs" />
                <label class="form-check-label" for="perm_docs">Docs</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="perm_changelog" />
                <label class="form-check-label" for="perm_changelog">Changelog</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark" onclick="saveRole()">Save Role</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extra-js')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
  // Define API endpoints with blade syntax (only works in .blade.php files)
  const API_USERS = '{{ route("admin.api.users") }}';
  const API_ROLES = '{{ route("admin.api.roles") }}';
  const API_USERS_STORE = '{{ route("admin.users.store") }}';
  const API_USERS_UPDATE = '{{ route("admin.users.update", ":userId") }}';
  const API_USERS_UPDATE_ROLE = '{{ route("admin.users.updateRole", ":userId") }}';
  const API_USERS_DELETE = '{{ route("admin.users.delete", ":userId") }}';
  const API_ROLES_STORE = '{{ route("admin.roles.store") }}';
  const API_ROLES_UPDATE = '{{ route("admin.roles.update", ":roleId") }}';
  const API_ROLES_DELETE = '{{ route("admin.roles.delete", ":roleId") }}';
</script>
<script src="{{ asset('js/backend/user-roles.js') }}"></script>
@endsection
