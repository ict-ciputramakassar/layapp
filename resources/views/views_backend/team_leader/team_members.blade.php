@extends('views_backend.layouts.app')

@section('title', 'Team Members - LayApp')

@push('styles')
  {{-- Menggunakan link import sesuai referensi --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
  <style>
    .avatar-md {
      height: 40px;
      width: 40px;
      object-fit: cover;
    }

    .table-responsive {
      padding: 20px;
      background: #fff;
      border-radius: 8px;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fs-3 mb-1">Team: <span id="teamNameDisplay">...</span></h1>
          <p class="mb-0">Manage your team members</p>
        </div>
        <div>
          <a href="{{ route('team_leader.add_team_member') }}" class="btn btn-primary">Add Member</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <!-- Toolbar / Filter (Mengikuti gaya referensi) -->
      <div class="mb-4">
        <div class="d-flex align-items-center gap-2 bg-light p-3 rounded shadow-sm">
          <div class="d-flex align-items-center gap-2">
            <label class="fw-bold text-nowrap">Filter By:</label>
            <select id="filterSelector" class="form-select w-auto">
              <option value="all">All Members</option>
              <option value="active">Active Only</option>
            </select>
          </div>
          <div class="flex-grow-1"></div>
          <button type="button" onclick="refreshDataTable()" class="btn btn-outline-secondary px-4">
            <i class="ti ti-refresh"></i> Reload Data
          </button>
        </div>
      </div>

      <div class="table-responsive shadow-sm">
        <table id="membersTable" class="table table-striped table-hover w-100">
          <thead>
            <tr>
              <th>No</th>
              <th>Member</th>
              <th>Type</th>
              <th>Category</th>
              <th>Position</th>
              <th>DOB</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Import sesuai referensi --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

  <script>
    let table;

    function refreshDataTable() {
      if (table) {
        table.destroy();
      }

      // URL API Anda
      let url = "{{ route('team_leader.get_members') }}";

      table = $('#membersTable').DataTable({
        ajax: {
          url: url,
          type: 'GET',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          dataSrc: function (res) {
            if (res.success) {
              // Update nama team di UI
              $('#teamNameDisplay').text(res.team.name);
              return res.members;
            } else {
              alert(res.message || "Unknown Error Occurred");
              return [];
            }
          }
        },
        ordering: true,
        columns: [
          {
            data: null,
            searchable: false,
            orderable: false
          },
          {
            data: null,
            render: function (data) {
              let img = data.image ? data.image : 'https://via.placeholder.com/40';
              return `
                                  <div class="d-flex align-items-center">
                                      <img src="${img}" class="avatar avatar-md rounded me-3" />
                                      <div>
                                          <div class="fw-bold">${data.full_name}</div>
                                          <small class="text-muted">${data.email || ''}</small>
                                      </div>
                                  </div>
                              `;
            }
          },
          {
            data: 'member_type.name',
            defaultContent: '-'
          },
          {
            data: 'age_category.name',
            defaultContent: '-'
          },
          {
            data: 'position.name',
            defaultContent: '-'
          },
          {
            data: 'dob',
            render: (data) => {
              // Menggunakan Day.js sesuai referensi
              return data ? dayjs(data, "D/M/YYYY").format('DD MMM YYYY') : '-';
            }
          },
          {
            data: 'id',
            render: function (id) {
              return `
                                  <div class="d-flex gap-2">
                                      <a href="/team-leader/edit/${id}" class="btn btn-sm btn-outline-primary">
                                          <i class="ti ti-edit"></i>
                                      </a>
                                      <button onclick="deleteMember('${id}')" class="btn btn-sm btn-outline-danger">
                                          <i class="ti ti-trash"></i>
                                      </button>
                                  </div>
                              `;
            }
          },
        ],
        drawCallback: function (settings) {
          var api = this.api();
          // Penomoran otomatis sesuai referensi
          api.column(0, {
            search: 'applied',
            order: 'applied'
          }).nodes().each((cell, i) => {
            cell.innerHTML = i + 1;
          });
        }
      });
    }

    $(document).ready(function () {
      // Load data pertama kali
      refreshDataTable();

      // Event listener filter (opsional, mengikuti pola referensi)
      $('#filterSelector').on('change', function () {
        // Anda bisa menambahkan logic filter server-side di sini jika perlu
        table.search(this.value === 'all' ? '' : this.value).draw();
      });
    });

    function deleteMember(id) {
      if (confirm('Are you sure you want to delete this member?')) {
        console.log('Deleting ID:', id);
        // Tambahkan logic AJAX delete di sini
      }
    }
  </script>

@endsection