@extends('views_backend.layouts.app')

@section('title', 'Event List - InApp Inventory Dashboard')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="">
        <h1 class="fs-3 mb-1">Event List</h1>
        <p class="mb-0">Manage your events</p>
      </div>
      <div>
        <a href="{{ route('admin.create-event') }}" class="btn btn-primary">Add Event</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div style="padding-bottom: 0.5rem;" class="card table-responsive">
      <table id="eventsTable" class="table mb-0 text-nowrap table-hover">
        <thead class="table-light border-light">
          <tr>
            <th>Logo</th>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Category Level</th>
            <th>Category Age</th>
            <th>Category Game</th>
            <th>Category Type</th>
            <th>EO Name</th>
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

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS with Bootstrap 5 Integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Determine the API endpoint based on user role
    const userRole = '{{ Auth::user()->userType?->code }}';
    const apiRoute = userRole === 'SA' ? '{{ route('superadmin.api.events.data') }}' : '{{ route('admin.api.events.data') }}';

    let table = $('#eventsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: apiRoute,
            type: 'GET'
        },
        columns: [
            {
                data: 'logo',
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" alt="Logo" class="avatar avatar-md rounded">';
                    }
                    return '<span class="text-muted">No logo</span>';
                },
                orderable: false,
                searchable: false
            },
            { data: 'name' },
            {
                data: 'start_date',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: 'end_date',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            { data: 'category_level' },
            { data: 'category_age' },
            { data: 'category_game' },
            { data: 'category_type' },
            { data: 'eo_name' },
            {
                data: 'id',
                render: function(data, type, row) {
                    const editRoute = userRole === 'SA' ? `/superadmin/events/${data}/edit` : `/admin/events/${data}/edit`;
                    return `
                        <a href="${editRoute}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0);" onclick="deleteEvent('${data}')" class="btn btn-sm btn-outline-danger">
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
    window.deleteEvent = function(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            const deleteRoute = userRole === 'SA' ? `/superadmin/events/${eventId}` : `/admin/events/${eventId}`;
            $.ajax({
                url: deleteRoute,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Event deleted successfully!');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error deleting event');
                    console.error(xhr);
                }
            });
        }
    };
});
</script>

@endsection
