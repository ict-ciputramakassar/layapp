@extends('views_backend.layouts.app')

@section('title', 'Group List - LayApp')

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
    .dt-type-numeric {
        text-align: left !important;
    }
</style>
@endpush

@section('content')

<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="">
        <h1 class="fs-3 mb-1">Group List</h1>
        <p class="mb-0">Manage your groups</p>
      </div>
      <div>
        <a href="{{ route('create-group') }}" class="btn btn-primary">Add Group</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div style="padding-bottom: 0.5rem;" class="card table-responsive py-1">
      <table id="groupsTable" class="table mb-0 text-nowrap table-hover">
        <thead class="table-light border-light">
          <tr>
            <th>Group Game</th>
            <th>Event Name</th>
            <th>Team Name</th>
            <th class="text-start">Play</th>
            <th class="text-start">Win</th>
            <th class="text-start">Lose</th>
            <th class="text-start">Draw</th>
            <th class="text-start">Point</th>
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
    const apiRoute = '{{ route('api.groups.data') }}';

    let table = $('#groupsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: apiRoute,
            type: 'GET'
        },
        columns: [
            { data: 'group_game_name', name: 'group_game_name' },
            { data: 'event_name',      name: 'event_name' },
            { data: 'team_name',       name: 'team_name' },
            { data: 'play',            name: 'play' ,               classname: 'text-start'},
            { data: 'win',             name: 'win' ,                classname: 'text-start'},
            { data: 'lose',            name: 'lose' ,               classname: 'text-start'},
            { data: 'draw',            name: 'draw' ,               classname: 'text-start'},
            { data: 'point',           name: 'point' ,              classname: 'text-start'},
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: 'Search groups:',
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
    window.deleteGroup = function(groupId) {
        if (confirm('Are you sure you want to delete this group?')) {
            const deleteRoute = `{{ route('group.destroy', ':id') }}`.replace(':id', groupId);
            $.ajax({
                url: deleteRoute,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Group deleted successfully!');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error deleting group');
                    console.error(xhr);
                }
            });
        }
    };
});
</script>
@endsection
