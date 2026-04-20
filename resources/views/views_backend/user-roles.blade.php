@extends('views_backend.layouts.app')

@section('title', 'User Roles - LayApp')

@push('styles')
<!-- DataTables CSS for Bootstrap 5 -->
<link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

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
      <div class="card overflow-hidden px-6 py-3">
        <div class="table-responsive">
          <table id="usersDataTable" class="table mb-0 text-nowrap table-hover table-centered w-100">
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
            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" onclick="resetRoleForm()">
              <i class="ti ti-plus"></i> Add Role
            </button>
          </div>
          <div id="rolesList" class="d-flex flex-column gap-2">
            <div class="p-4 bg-light rounded-2 border mb-2">
              <h6 class="mb-1">Loading roles...</h6>
              <p class="text-muted small mb-0">Fetching...</p>
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
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input id="name" type="text" class="form-control" placeholder="Full Name" required/>
          </div>
          <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input id="email" type="email" class="form-control" placeholder="Email" required/>
          </div>
          <div class="mb-3 phone-field">
            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
            <input id="phone" type="tel" class="form-control" placeholder="Phone Number" required/>
          </div>
          <div class="mb-3 password-field" style="display: none;">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input id="password" type="password" class="form-control" placeholder="Password" required/>
              <span class="input-group-text" style="cursor: pointer;" onclick="togglePasswordVisibility('password')">
                <i class="ti ti-eye" id="toggle-icon-password"></i>
              </span>
            </div>
          </div>
          <div class="mb-3 password-field" style="display: none;">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input id="confirm_password" type="password" class="form-control" placeholder="Repeat Password" required/>
              <span class="input-group-text" style="cursor: pointer;" onclick="togglePasswordVisibility('confirm_password')">
                <i class="ti ti-eye" id="toggle-icon-confirm_password"></i>
              </span>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select id="role" class="form-select" required>
              <option value="" disabled selected>Select a role...</option>
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
                  <input class="form-check-input" type="checkbox" id="perm_reports" />
                  <label class="form-check-label" for="perm_reports">Reports</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="perm_event_list" />
                  <label class="form-check-label" for="perm_event_list">Event List</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="perm_create_event" />
                    <label class="form-check-label" for="perm_create_event">Add Event</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="perm_schedule_list" />
                  <label class="form-check-label" for="perm_schedule_list">Schedule List</label>
                </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_create_schedule" />
                <label class="form-check-label" for="perm_create_schedule">Create Schedule</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_team_members" />
                <label class="form-check-label" for="perm_team_members">Team Members</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_add_team_members" />
                <label class="form-check-label" for="perm_add_team_members">Add Team Members</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="perm_score_list" />
                <label class="form-check-label" for="perm_score_list">Score List</label>
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
  const API_USERS = '{{ route("api.users") }}';
  const API_ROLES = '{{ route("api.roles") }}';
  const API_USERS_STORE = '{{ route("users.store") }}';
  const API_USERS_UPDATE = '{{ route("users.update", ":userId") }}';
  const API_USERS_UPDATE_ROLE = '{{ route("users.updateRole", ":userId") }}';
  const API_USERS_DELETE = '{{ route("users.delete", ":userId") }}';
  const API_ROLES_STORE = '{{ route("roles.store") }}';
  const API_ROLES_UPDATE = '{{ route("roles.update", ":roleId") }}';
  const API_ROLES_DELETE = '{{ route("roles.delete", ":roleId") }}';

  function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById('toggle-icon-' + inputId);
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('ti-eye');
      icon.classList.add('ti-eye-off');
    } else {
      input.type = 'password';
      icon.classList.remove('ti-eye-off');
      icon.classList.add('ti-eye');
    }
  }
</script>
<!-- jQuery, DataTables & Bootstrap 5 UI Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('js/backend/user-roles.js') }}"></script>
@endsection
