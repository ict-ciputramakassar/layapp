@extends('views_backend.layouts.app')

@section('title', 'Team Members - LayApp')

@push('styles')
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
  <!-- MODAL KONFIRMASI DELETE -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteMemberName"></strong>?
          <input type="hidden" id="deleteMemberId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fs-3 mb-1">Team: <span id="teamNameDisplay">{{ $user->team->name ?? 'Loading...' }}</span></h1>
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
      <!-- TOOLBAR / FILTER FORM -->
      <div class="mb-4">
        <form id="searchForm" class="bg-light p-3 rounded shadow-sm d-flex flex-wrap align-items-center gap-3">

          <!-- 1. ALWAYS PERSIST: Status Filter -->
          <div class="d-flex align-items-center gap-2">
            <label class="fw-bold text-nowrap mb-0">Status:</label>
            <select id="filterStatus" class="form-select w-auto">
              <option value="both" selected>Both (All)</option>
              <option value="1">Active Only</option>
              <option value="0">Inactive Only</option>
            </select>
          </div>

          <div class="vr d-none d-md-block"></div>

          <!-- 2. DYNAMIC FILTER SELECTOR -->
          <div class="d-flex align-items-center gap-2">
            <label class="fw-bold text-nowrap mb-0">Filter By:</label>
            <select id="filterSelector" class="form-select w-auto">
              <option value="all">-- Show All --</option>
              <option value="name">Member Name</option>
              <option value="type">Member Type</option>
              <option value="dob">DOB (Year)</option>
              <option value="date_range">Start - End Date</option>
            </select>
          </div>

          <!-- 3. DYNAMIC INPUT CONTAINERS -->
          <div id="dynamicInputs" class="flex-grow-1">
            <div id="input-name" class="filter-input-group d-none">
              <input type="text" id="val_name" class="form-control" placeholder="Enter member name...">
            </div>
            <div id="input-type" class="filter-input-group d-none">
              <select id="val_type" class="form-select">
                <option value="" selected disabled>Select Type...</option>
                @foreach($types ?? [] as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
            </div>
            <div id="input-dob" class="filter-input-group d-none">
              <input type="number" id="val_dob" class="form-control" placeholder="e.g. 2005" min="1950" max="2030">
            </div>
            <div id="input-date_range" class="filter-input-group d-none d-flex gap-2">
              <input type="date" id="val_start_date" class="form-control" title="Start Date">
              <span class="align-self-center">to</span>
              <input type="date" id="val_end_date" class="form-control" title="End Date">
            </div>
          </div>

          <!-- 4. BUTTONS -->
          <div>
            <button type="submit" id="searchBtn" class="btn btn-primary px-4">
              <i class="ti ti-search me-1"></i> Search
            </button>
            {{-- <button type="button" id="resetBtn" class="btn btn-outline-secondary ms-1">Reset</button> --}}
          </div>
        </form>
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
          <tbody>
            <!-- Kosong di awal -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

  <script>
    let table;
    let deleteModalInstance;

    $(document).ready(function () {

      // 1. INISIALISASI DATATABLES (KOSONG DI AWAL, TANPA AJAX)
      table = $('#membersTable').DataTable({
        data: [], // Data kosong di awal
        ordering: true,
        columns: [
          { data: null, searchable: false, orderable: false },
          {
            data: null,
            render: function (data) {
              // KODE GAMBAR ANDA DIKEMBALIKAN SEPERTI SEMULA
              let img = `{{ asset('${data.image}') }}`;
              let statusBadge = data.is_active == 0 ? '<span class="badge bg-danger ms-2" style="font-size:10px;">Inactive</span>' : '';

              return `
                    <div class="d-flex align-items-center">
                        <img src="${img}" class="avatar avatar-md rounded me-3" style="object-fit: cover;" />
                        <div>
                            <div class="fw-bold">${data.full_name} ${statusBadge}</div>
                            <small class="text-muted">${data.email || ''}</small>
                        </div>
                    </div>
                  `;
            }
          },
          { data: 'member_type.name', defaultContent: '-' },
          { data: 'age_category.name', defaultContent: '-' },
          { data: 'position.name', defaultContent: '-' },
          {
            data: 'dob',
            render: (data) => data ? dayjs(data, "D/M/YYYY").format('DD MMM YYYY') : '-'
          },
          {
            data: null,
            render: function (row) {
              let editUrl = "{{ route('team_leader.edit_member', ':id') }}".replace(':id', row.id);
              let actionButtons = `<div class="d-flex gap-2"><a href="${editUrl}" class="btn btn-sm btn-outline-primary"><i class="ti ti-edit"></i></a>`;
              if (row.is_active == 1) {
                actionButtons += `<button onclick="showDeleteModal('${row.id}', '${row.full_name}')" class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>`;
              }
              actionButtons += `</div>`;
              return actionButtons;
            }
          },
        ],
        drawCallback: function (settings) {
          var api = this.api();
          api.column(0, { search: 'applied', order: 'applied' }).nodes().each((cell, i) => {
            cell.innerHTML = i + 1;
          });
        }
      });

      deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

      // 2. LOGIKA UI: Tampilkan/Sembunyikan Input Filter
      function filterSelect() {
        let selectedFilter = $('#filterSelector').val();
        $('.filter-input-group').addClass('d-none');
        $('#val_name, #val_type, #val_dob, #val_start_date, #val_end_date').val('');
        if (selectedFilter !== 'all') {
          $('#input-' + selectedFilter).removeClass('d-none');
        }
      }
      filterSelect();
      $('#filterSelector').on('change', filterSelect);

      // 3. EVENT: TOMBOL SEARCH DITEKAN (BARU AMBIL DATA)
      $('#searchForm').on('submit', function (e) {
        e.preventDefault();

        let activeFilter = $('#filterSelector').val();

        // Validasi
        if (activeFilter === 'name' && !$('#val_name').val()) return alert('Please enter a name');
        if (activeFilter === 'type' && !$('#val_type').val()) return alert('Please select a type');
        if (activeFilter === 'dob' && !$('#val_dob').val()) return alert('Please enter a year');
        if (activeFilter === 'date_range' && (!$('#val_start_date').val() || !$('#val_end_date').val())) {
          return alert('Please select both start and end dates');
        }

        // Siapkan data yang akan dikirim ke Controller
        let payload = {
          status: $('#filterStatus').val()
        };

        if (activeFilter === 'name') payload.full_name = $('#val_name').val();
        if (activeFilter === 'type') payload.member_type = $('#val_type').val();
        if (activeFilter === 'dob') payload.dob_year = $('#val_dob').val();
        if (activeFilter === 'date_range') {
          payload.start_date = $('#val_start_date').val();
          payload.end_date = $('#val_end_date').val();
        }

        let btn = $('#searchBtn');
        let originalText = btn.html();
        btn.html('<i class="ti ti-loader"></i> Searching...').prop('disabled', true);

        // Lakukan AJAX Request Manual
        $.ajax({
          url: "{{ route('team_leader.get_members') }}",
          type: "GET",
          data: payload, // Mengirim data filter ke controller
          success: function (res) {
            if (res.success) {
              // Masukkan data baru ke DataTables
              table.clear().rows.add(res.members).draw();
            } else {
              alert(res.message);
            }
          },
          error: function () {
            alert("Failed to fetch data.");
          },
          complete: function () {
            btn.html(originalText).prop('disabled', false);
          }
        });
      });

      // 4. EVENT: Tombol Reset
      // $('#resetBtn').on('click', function() {
      //   $('#filterStatus').val('1');
      //   $('#filterSelector').val('all').trigger('change');
      //   table.clear().draw(); // Kosongkan tabel kembali
      // });

      // 5. EVENT: Tombol Confirm Delete
      $('#confirmDeleteBtn').on('click', function () {
        let id = $('#deleteMemberId').val();
        let btn = $(this);
        let deleteUrl = "{{ route('team_leader.delete_member', ':id') }}".replace(':id', id);

        let originalText = btn.html();
        btn.html('Deleting...').prop('disabled', true);

        fetch(deleteUrl, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
          .then(async response => {
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Something went wrong');
            return data;
          })
          .then(data => {
            if (data.success) {
              deleteModalInstance.hide();
              $('#searchForm').submit(); // Refresh tabel dengan filter yang sedang aktif
            }
          })
          .catch(error => { alert(error.message); })
          .finally(() => { btn.html(originalText).prop('disabled', false); });
      });
    });

    function showDeleteModal(id, name) {
      $('#deleteMemberId').val(id);
      $('#deleteMemberName').text(name);
      deleteModalInstance.show();
    }
  </script>
@endsection
