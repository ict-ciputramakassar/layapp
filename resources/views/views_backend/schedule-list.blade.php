@extends('views_backend.layouts.app')

@section('title', 'Schedule List - LayApp')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="">
        <h1 class="fs-3 mb-1">Schedule List</h1>
        <p class="mb-0">Manage your schedules</p>
      </div>
      <div>
        <a href="{{ route('create-schedule') }}" class="btn btn-primary">Add Schedule</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div style="padding-bottom: 0.5rem;" class="card table-responsive py-1">
      <table id="schedulesTable" class="table mb-0 text-nowrap table-hover">
        <thead class="table-light border-light">
          <tr>
            <th>Event Name</th>
            <th>Team Home</th>
            <th>Team Away</th>
            <th class="text-center">Score Home</th>
            <th class="text-center">Score Away</th>
            <th>Play Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <footer class="text-center py-2 mt-6 text-secondary">
      <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://wyattmatt.github.io/" target="_blank" class="text-primary">WyattMatt</a></p>
    </footer>
  </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS with Bootstrap 5 Integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
<style>
    /* Force DataTables sorting icons to the right side consistently */
    table.dataTable thead th {
        position: relative !important;
        padding-right: 30px !important; /* Make room for the icon */
    }
    table.dataTable thead th .dt-column-order {
        position: absolute !important;
        right: 8px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
    }
    /* Stop DataTables flexbox from overriding alignments */
    table.dataTable thead th .dt-column-title {
        display: block !important;
    }
    table.dataTable thead th.text-center .dt-column-title {
        text-align: center !important;
    }
    table.dataTable thead th.text-start .dt-column-title {
        text-align: left !important;
    }
</style>
@endpush

@section('extra-js')
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const apiRoute = '{{ route('api.schedule.list') }}';

    let table = $('#schedulesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: apiRoute,
            type: 'GET'
        },
        columns: [
            { data: 'event_name' },
            { data: 'team_home' },
            { data: 'team_away' },
            { data: 'score_h', className: 'text-start' },
            { data: 'score_a', className: 'text-start' },
            { data: 'play_date', className: 'text-start' },
            {
                data: 'id',
                render: function(data, type, row) {
                    const editRoute = `/schedule/${data}/edit`;
                    return `
                        <a href="${editRoute}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0);" onclick="deleteSchedule('${data}')" class="btn btn-sm btn-outline-danger">
                            <i class="ti ti-trash"></i> Delete
                        </a>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: 'Search events:',
            lengthMenu: '_MENU_ entries per page',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            paginate: {
                first: '<i class="ti ti-chevrons-left"></i>',
                last: '<i class="ti ti-chevrons-right"></i>',
                next: '<i class="ti ti-chevron-right"></i>',
                previous: '<i class="ti ti-chevron-left"></i>'
            }
        }
    });

    // Delete function
    window.deleteSchedule = function(scheduleId) {
        if (confirm('Are you sure you want to delete this schedule?')) {
            const deleteRoute = `/schedule/${scheduleId}`;
            $.ajax({
                url: deleteRoute,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Schedule deleted successfully!');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error deleting schedule');
                    console.error(xhr);
                }
            });
        }
    };
});
</script>
@endsection
