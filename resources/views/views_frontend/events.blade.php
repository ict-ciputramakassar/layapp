@extends('views_frontend.layouts.app')

@section('title', 'Events - LayApp')

@section('content')

<style>
    /* Styling tambahan untuk tabel modal */
    .table-container { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; margin-bottom: 15px; }
    .table-container th { position: sticky; top: 0; background: #f8f9fa; z-index: 10; box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1); }
    .search-input { margin-bottom: 15px; }
    .filter-group { display: flex; gap: 10px; margin-bottom: 15px; }
    .filter-group > div { flex: 1; }

    /* --- EVENTS GRID --- */
    #events-container {
        display: flex;
        flex-wrap: wrap;
    }

    #events-container > div[class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    .event-card {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background: #fff;
    }

    .card.event-card {
        margin-bottom: 0;
    }

    .event-card-content {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* --- PAGINATION --- */
    .pg-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 30px;
        font-family: inherit;
    }
    .pg-list {
        display: inline-flex;
        list-style: none;
        padding: 0;
        margin: 0;
        background: #ebebeb;
        border-radius: 6px;
        overflow: hidden;
    }
    .pg-item {
        margin: 0;
    }
    .pg-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        min-width: 40px;
        color: #337ab7;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .pg-link:hover {
        background-color: #dcdcdc;
        text-decoration: none;
    }
    .pg-item.active .pg-link {
        background-color: #337ab7;
        color: #fff;
        cursor: default;
    }
    .pg-item.active .pg-link:hover {
        background-color: #337ab7;
    }
    .pg-item.disabled .pg-link {
        color: #aaa;
        cursor: not-allowed;
        background-color: transparent;
    }
    .pg-item.disabled .pg-link:hover {
        background-color: transparent;
    }
    /* --------------------------- */
</style>

<div class="inner-page-banner">
    <div class="container"></div>
</div>
<div class="inner-information-text">
    <div class="container">
        <h3>Our Events</h3>
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="active">Our Events</li>
        </ul>
    </div>
</div>

<section id="contant" class="contant main-heading team">
    <div class="row">
        <div class="container">
            <div id="events-container" class="row">
                <div style="width: 100%; min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <i class="fa fa-spinner fa-spin fa-2x" style="margin-bottom: 10px;"></i>
                    <p style="text-align: center; margin: 0;">Loading events...</p>
                </div>
            </div>

            <!-- PAGINATION CONTAINER -->
            <div class="row">
                <div id="pagination-container" class="col-md-12 text-center mt-4">
                </div>
            </div>

        </div>
    </div>
</section>

<div id="registerEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #e32124; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="registerModalLabel" style="color: white; margin: 0;">Event Registration</h4>
            </div>
            <div class="modal-body">
                <p>You will register to event: <strong id="modalEventName" style="color: #e32124;"></strong></p>

                <form id="registerEventForm">
                    <input type="hidden" id="modalEventId">

                    <div class="form-group" style="margin-top: 20px;">
                        <label>Select Players - <span id="selectionCounter" class="text-danger font-weight-bold">0/20 Terpilih</span></label>

                        <div class="filter-group">
                            <div>
                                <input type="text" id="searchPlayer" class="form-control" placeholder="Ketik nama pemain..." onkeyup="filterPlayers()">
                            </div>
                            <div>
                                <select id="filterPosition" class="form-control" onchange="filterPlayers()">
                                    <option value="">Semua Posisi</option>
                                </select>
                            </div>
                            <div>
                                <select id="filterAge" class="form-control" onchange="filterPlayers()">
                                    <option value="">Semua Kategori Umur</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive table-container">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10%">Select</th>
                                        <th>Player Name</th>
                                        <th>Position</th>
                                        <th>Age Category</th>
                                    </tr>
                                </thead>
                                <tbody id="playersTableBody">
                                    <tr><td colspan="4" class="text-center"><i class="fa fa-spinner fa-spin"></i> Fetching players data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSubmitRegister" onclick="submitRegistration()" style="background: #e32124; border-color: #e32124;">Send Registration</button>
            </div>
        </div>
    </div>
</div>

<script>
    const isTeamLeader = @json($isTeamLeader);
    let selectedPlayers = []; // Menyimpan ID pemain yang dipilih
    const MAX_PLAYERS = 20;
    const MIN_PLAYERS = 13;

    // PAGINATION & DATA STATE
    let allEvents = [];
    let currentPage = 1;
    const itemsPerPage = 16;

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch List Events
        fetch('{{ route("api.events-frontend") }}')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    allEvents = data.data;
                    renderEvents();
                } else {
                    document.getElementById('events-container').innerHTML = '<div style="width: 100%; min-height: 400px; display: flex; justify-content: center; align-items: center;"><p style="text-align: center; margin: 0;">Belum ada event yang tersedia saat ini.</p></div>';
                    document.getElementById('pagination-container').innerHTML = '';
                }
            })
            .catch(error => {
                document.getElementById('events-container').innerHTML = '<div class="text-danger" style="width: 100%; min-height: 400px; display: flex; justify-content: center; align-items: center;"><p style="text-align: center; margin: 0;">Gagal memuat event.</p></div>';
                document.getElementById('pagination-container').innerHTML = '';
            });
    });

    function renderEvents() {
        const container = document.getElementById('events-container');

        // Calculate slice
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageEvents = allEvents.slice(startIndex, endIndex);

        let html = '';

        pageEvents.forEach(event => {
            let registerBtn = isTeamLeader
                ? `<div class="center" style="margin-top:auto; padding-top: 15px;"><button class="btn btn-danger btn-block" onclick="openRegisterModal('${event.id}', '${event.name.replace(/'/g, "\\'")}')">Daftar Event</button></div>`
                : '';

            html += `
                <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                    <div class="card event-card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px; border-radius: 8px;">
                        <img class="img-responsive" src="/${event.logo}" style="width:100%; height: 200px; object-fit: cover; border-radius: 6px;">
                        <div class="event-card-content">
                            <h4 style="margin-bottom: 10px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${event.name}">${event.name}</h4>
                            <p style="margin-bottom: 5px; font-size: 13px; color: #555;"><i class="fa fa-calendar"></i> Mulai: ${event.start_date}</p>
                            <p style="margin-bottom: 5px; font-size: 13px; color: #555;"><i class="fa-solid fa-calendar-xmark"></i> Berakhir: ${event.end_date}</p>
                            ${registerBtn}
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        renderPagination();
    }

    function renderPagination() {
        const totalItems = allEvents.length;
        const paginationContainer = document.getElementById('pagination-container');

        if (totalItems === 0) {
            paginationContainer.innerHTML = '';
            return;
        }

        const totalPages = Math.ceil(totalItems / itemsPerPage);

        let html = '<div class="pg-wrapper">';
        html += '<ul class="pg-list">';

        // First button
        html += `<li class="pg-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="pg-link" href="javascript:void(0)" onclick="if(currentPage > 1) { currentPage = 1; renderEvents(); }">&laquo;</a>
                 </li>`;

        // Prev button
        html += `<li class="pg-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="pg-link" href="javascript:void(0)" onclick="if(currentPage > 1) { currentPage--; renderEvents(); }">&lsaquo;</a>
                 </li>`;

        // Numbers
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="pg-item ${currentPage === i ? 'active' : ''}">
                        <a class="pg-link" href="javascript:void(0)" onclick="currentPage = ${i}; renderEvents();">${i}</a>
                     </li>`;
        }

        // Next button
        html += `<li class="pg-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="pg-link" href="javascript:void(0)" onclick="if(currentPage < ${totalPages}) { currentPage++; renderEvents(); }">&rsaquo;</a>
                 </li>`;

        // Last button
        html += `<li class="pg-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="pg-link" href="javascript:void(0)" onclick="if(currentPage < ${totalPages}) { currentPage = ${totalPages}; renderEvents(); }">&raquo;</a>
                 </li>`;

        html += '</ul></div>';
        paginationContainer.innerHTML = html;
    }

    // 1. FUNGSI BUKA MODAL & LOAD PEMAIN
    function openRegisterModal(eventId, eventName) {
        document.getElementById('modalEventName').innerText = eventName;
        document.getElementById('modalEventId').value = eventId;

        // Reset Modal
        document.getElementById('searchPlayer').value = '';
        document.getElementById('selectionCounter').innerText = `0/${MAX_PLAYERS} Terpilih`;
        selectedPlayers = [];

        $('#registerEventModal').modal('show');

        // Panggil API get_members
        fetch('{{ route("get_members") }}')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('playersTableBody');
                if (data.success && data.members) {

                    // FILTER: Hanya ambil yang depannya AT (Athlete)
                    const athletes = data.members.filter(m => m.member_type && m.member_type.code.startsWith('AT') && m.is_active == 1);

                    if(athletes.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Tidak ada atlet yang tersedia di tim Anda.</td></tr>';
                        return;
                    }

                    let tableHtml = '';
                    let positions = new Set();
                    let ages = new Set();

                    athletes.forEach(a => {
                        let pos = a.position ? a.position.name : '-';
                        let age = a.age_category ? a.age_category.name : '-';

                        positions.add(pos);
                        ages.add(age);

                        tableHtml += `
                            <tr class="player-row" data-pos="${pos}" data-age="${age}">
                                <td class="text-center">
                                    <input type="checkbox" class="chk-player" value="${a.id}" onchange="handleCheckbox(this)">
                                </td>
                                <td class="player-name-cell">${a.full_name}</td>
                                <td>${pos}</td>
                                <td>${age}</td>
                            </tr>
                        `;
                    });

                    tbody.innerHTML = tableHtml;

                    // Populate Filter Dropdowns dynamically
                    const filterPos = document.getElementById('filterPosition');
                    const filterAge = document.getElementById('filterAge');

                    filterPos.innerHTML = '<option value="">Semua Posisi</option>';
                    filterAge.innerHTML = '<option value="">Semua Kategori Umur</option>';

                    Array.from(positions).sort().forEach(p => {
                        if(p !== '-') filterPos.innerHTML += `<option value="${p}">${p}</option>`;
                    });

                    Array.from(ages).sort().forEach(a => {
                        if(a !== '-') filterAge.innerHTML += `<option value="${a}">${a}</option>`;
                    });

                } else {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Gagal memuat data pemain.</td></tr>';
                }
            })
            .catch(err => {
                document.getElementById('playersTableBody').innerHTML = '<tr><td colspan="4" class="text-center text-danger">Terjadi kesalahan sistem.</td></tr>';
            });
    }

    // 2. FUNGSI CHECKBOX (Limit maksimal)
    function handleCheckbox(checkbox) {
        if (checkbox.checked) {
            if (selectedPlayers.length >= MAX_PLAYERS) {
                checkbox.checked = false; // Batalkan centang
                alert(`You can only choose up to ${MAX_PLAYERS} players.`);
                return;
            }
            selectedPlayers.push(checkbox.value);
        } else {
            selectedPlayers = selectedPlayers.filter(id => id !== checkbox.value);
        }

        // Update Counter
        document.getElementById('selectionCounter').innerText = `${selectedPlayers.length}/${MAX_PLAYERS} Selected`;

        // Disable sisanya jika sudah mencapai batas maksimal
        const allCheckboxes = document.querySelectorAll('.chk-player');
        allCheckboxes.forEach(cb => {
            if (!cb.checked) {
                cb.disabled = selectedPlayers.length >= MAX_PLAYERS;
            }
        });
    }

    // 3. FUNGSI PENCARIAN & FILTER MULTI-KRITERIA (Advanced)
    function filterPlayers() {
        const keyword = document.getElementById('searchPlayer').value.toLowerCase();
        const posValue = document.getElementById('filterPosition').value;
        const ageValue = document.getElementById('filterAge').value;

        const rows = document.querySelectorAll('.player-row');

        rows.forEach(row => {
            const name = row.querySelector('.player-name-cell').innerText.toLowerCase();
            const pos = row.getAttribute('data-pos');
            const age = row.getAttribute('data-age');

            const matchName = name.includes(keyword);
            const matchPos = posValue === "" || pos === posValue;
            const matchAge = ageValue === "" || age === ageValue;

            if (matchName && matchPos && matchAge) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // 4. FUNGSI SUBMIT KE API
    function submitRegistration() {
        if (selectedPlayers.length < MIN_PLAYERS) {
            alert(`Needs at Least ${MIN_PLAYERS} Players!`);
            return;
        }

        const btnSubmit = document.getElementById('btnSubmitRegister');
        btnSubmit.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        btnSubmit.disabled = true;

        const payload = {
            event_id: document.getElementById('modalEventId').value,
            player_ids: selectedPlayers // Array ID pemain terpilih
        };

        fetch('{{ route("api.event.register") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            btnSubmit.innerHTML = 'Send Registration';
            btnSubmit.disabled = false;

            if (data.success) {
                alert('Registration Success!');
                $('#registerEventModal').modal('hide');
            } else {
                alert(data.message || 'An error occured during registration.');
            }
        })
        .catch(err => {
            btnSubmit.innerHTML = 'Send Registration';
            btnSubmit.disabled = false;
            alert('Failed to connect to server, please try again.');
        });
    }
</script>
@endsection
