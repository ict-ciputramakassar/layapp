@extends('views_backend.layouts.app')

@section('title', 'Event List - LayApp')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="">
        <h1 class="fs-3 mb-1">Event List</h1>
        <p class="mb-0">Manage your events & registrations</p>
      </div>
      <div>
        <a href="{{ route('create-event') }}" class="btn btn-primary">Add Event</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div style="padding-bottom: 0.5rem;" class="card table-responsive py-1">
      <table id="eventsTable" class="table mb-0 text-nowrap table-hover">
        <thead class="table-light border-light">
          <tr>
            <th>Logo</th>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Category Level</th>
            <th>Category Age</th>
            <th>EO Name</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL REGISTRASI UNTUK ADMIN -->
<div id="adminRegisterModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Admin Registration Portal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Mendaftarkan tim untuk event: <strong id="modalEventName"></strong>
                </div>

                <form id="adminRegisterForm">
                    <input type="hidden" id="modalEventId">
                    
                    <!-- STEP 1: PILIH TIM -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">1. Pilih Tim</label>
                        <select id="selectTeam" class="form-select" onchange="loadTeamPlayers(this.value)">
                            <option value="">-- Pilih Tim yang Akan Didaftarkan --</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <!-- STEP 2: PILIH PEMAIN -->
                    <div id="playerSelectionSection" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="fw-bold">2. Pilih Anggota Tim (Pemain)</label>
                            <span id="selectionCounter" class="badge bg-danger">0/20 Terpilih</span>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <input type="text" id="searchPlayer" class="form-control form-control-sm" placeholder="Cari nama..." onkeyup="filterPlayers()">
                            </div>
                            <div class="col-md-3">
                                <select id="filterPosition" class="form-select form-select-sm" onchange="filterPlayers()">
                                    <option value="">Posisi</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="filterAge" class="form-select form-select-sm" onchange="filterPlayers()">
                                    <option value="">Umur</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive border rounded" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="text-center">Pilih</th>
                                        <th>Nama</th>
                                        <th>Posisi</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody id="playersTableBody">
                                    <tr><td colspan="4" class="text-center text-muted">Silahkan pilih tim terlebih dahulu</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSubmitAdminReg" onclick="submitAdminRegistration()">Simpan Pendaftaran</button>
            </div>
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
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">
<style>
    .sticky-top { position: sticky; top: 0; z-index: 10; }
</style>
@endpush

@section('extra-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const apiRoute = '{{ route('api.events.data') }}';
    let selectedPlayers = [];
    const MAX_PLAYERS = 20;
    const MIN_PLAYERS = 13;

    let table = $('#eventsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: apiRoute,
        columns: [
            {
                data: 'logo',
                render: data => data ? `<img src="/${data}" class="img-fluid" style="max-height: 40px;">` : 'No logo',
                orderable: false, searchable: false
            },
            { data: 'name' },
            { data: 'start_date', render: d => new Date(d).toLocaleDateString() },
            { data: 'end_date', render: d => new Date(d).toLocaleDateString() },
            { data: 'category_level' },
            { data: 'category_age' },
            { data: 'eo_name' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button onclick="openAdminRegModal('${data}', '${row.name.replace(/'/g, "\\'")}')" class="btn btn-sm btn-success">
                                <i class="ti ti-users"></i> Register Team
                            </button>
                            <a href="/events/${data}/edit" class="btn btn-sm btn-outline-primary"><i class="ti ti-edit"></i></a>
                            <button onclick="deleteEvent('${data}')" class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                        </div>
                    `;
                },
                orderable: false, searchable: false
            }
        ]
    });

    // OPEN MODAL LOGIC
    window.openAdminRegModal = function(id, name) {
        $('#modalEventId').val(id);
        $('#modalEventName').text(name);
        $('#selectTeam').val('');
        $('#playerSelectionSection').hide();
        selectedPlayers = [];
        updateCounter();
        $('#adminRegisterModal').modal('show');
    };

    // LOAD PLAYERS BASED ON TEAM
    window.loadTeamPlayers = function(teamId) {
        // RESET PILIHAN PEMAIN SETIAP KALI TIM DIGANTI
        selectedPlayers = [];
        updateCounter();

        if (!teamId) {
            $('#playerSelectionSection').hide();
            return;
        }

        $('#playerSelectionSection').show();
        $('#playersTableBody').html('<tr><td colspan="4" class="text-center"><i class="ti ti-loader rotate"></i> Loading...</td></tr>');

        // Menggunakan Route Name Laravel dengan me-replace placeholder ":id"
        let urlTemplate = '{{ route("team_members_by_team_id", ":id") }}';
        let fetchUrl = urlTemplate.replace(':id', teamId);

        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                let html = '';
                let positions = new Set();
                let ages = new Set();
                
                if (data.members && data.members.length > 0) {
                    // Filter AT (Athletes) as per reference
                    const athletes = data.members.filter(m => m.member_type && m.member_type.code.startsWith('AT'));
                    
                    athletes.forEach(p => {
                        let pos = p.position ? p.position.name : '-';
                        let age = p.age_category ? p.age_category.name : '-';
                        positions.add(pos);
                        ages.add(age);

                        html += `
                            <tr class="player-row" data-pos="${pos}" data-age="${age}">
                                <td class="text-center">
                                    <input type="checkbox" class="chk-player" value="${p.id}" onchange="handleAdminCheckbox(this)">
                                </td>
                                <td class="p-name">${p.full_name}</td>
                                <td>${pos}</td>
                                <td>${age}</td>
                            </tr>
                        `;
                    });
                    $('#playersTableBody').html(html);
                    populateFilters(positions, ages);
                } else {
                    $('#playersTableBody').html('<tr><td colspan="4" class="text-center text-danger">Tidak ada pemain aktif.</td></tr>');
                }
            });
    };

    window.handleAdminCheckbox = function(cb) {
        if (cb.checked) {
            if (selectedPlayers.length >= MAX_PLAYERS) {
                cb.checked = false;
                alert('Maksimal 20 pemain!');
                return;
            }
            selectedPlayers.push(cb.value);
        } else {
            selectedPlayers = selectedPlayers.filter(id => id !== cb.value);
        }
        updateCounter();
    };

    function updateCounter() {
        $('#selectionCounter').text(`${selectedPlayers.length}/${MAX_PLAYERS} Terpilih`);
    }

    function populateFilters(positions, ages) {
        let pFilter = '<option value="">Posisi</option>';
        let aFilter = '<option value="">Umur</option>';
        positions.forEach(p => pFilter += `<option value="${p}">${p}</option>`);
        ages.forEach(a => aFilter += `<option value="${a}">${a}</option>`);
        $('#filterPosition').html(pFilter);
        $('#filterAge').html(aFilter);
    }

    window.filterPlayers = function() {
        const key = $('#searchPlayer').val().toLowerCase();
        const pos = $('#filterPosition').val();
        const age = $('#filterAge').val();

        $('.player-row').each(function() {
            const nameMatch = $(this).find('.p-name').text().toLowerCase().includes(key);
            const posMatch = !pos || $(this).data('pos') === pos;
            const ageMatch = !age || $(this).data('age') === age;
            $(this).toggle(nameMatch && posMatch && ageMatch);
        });
    };

    window.submitAdminRegistration = function() {
        if (selectedPlayers.length < MIN_PLAYERS) {
            alert(`Minimal harus memilih ${MIN_PLAYERS} pemain!`);
            return;
        }

        const teamId = $('#selectTeam').val();
        const eventId = $('#modalEventId').val();

        const btn = $('#btnSubmitAdminReg');
        btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: '{{ route("api.admin.event.register") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_id: eventId,
                team_id: teamId,
                player_ids: selectedPlayers
            },
            success: function(res) {
                alert('Pendaftaran Berhasil!');
                $('#adminRegisterModal').modal('hide');
                btn.prop('disabled', false).text('Simpan Pendaftaran');
            },
            error: function(err) {
                alert(err.responseJSON?.message || 'Terjadi kesalahan saat mendaftar.');
                btn.prop('disabled', false).text('Simpan Pendaftaran');
            }
        });
    };
});
</script>
@endsection