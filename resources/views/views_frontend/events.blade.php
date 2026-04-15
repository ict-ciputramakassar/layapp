@extends('views_frontend.layouts.app')

@section('title', 'Game Info')

@section('content')
<style>
    /* Styling tambahan untuk tabel modal */
    .table-container { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; margin-bottom: 15px; }
    .table-container th { position: sticky; top: 0; background: #f8f9fa; z-index: 10; box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1); }
    .search-input { margin-bottom: 15px; }
    .filter-group { display: flex; gap: 10px; margin-bottom: 15px; }
    .filter-group > div { flex: 1; }
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
                <div class="col-md-12 text-center">
                    <p><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading events...</p>
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
                <h4 class="modal-title" id="registerModalLabel" style="color: white; margin: 0;">Pendaftaran Event</h4>
            </div>
            <div class="modal-body">
                <p>Anda akan mendaftarkan tim ke event: <strong id="modalEventName" style="color: #e32124;"></strong></p>

                <form id="registerEventForm">
                    <input type="hidden" id="modalEventId">

                    <div class="form-group" style="margin-top: 20px;">
                        <label>Pilih Pemain (Maksimal 13 Pemain) - <span id="selectionCounter" class="text-danger font-weight-bold">0/13 Terpilih</span></label>

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
                                        <th class="text-center" width="10%">Pilih</th>
                                        <th>Nama Pemain</th>
                                        <th>Posisi</th>
                                        <th>Kategori Umur</th>
                                    </tr>
                                </thead>
                                <tbody id="playersTableBody">
                                    <tr><td colspan="4" class="text-center"><i class="fa fa-spinner fa-spin"></i> Mengambil data pemain...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSubmitRegister" onclick="submitRegistration()" style="background: #e32124; border-color: #e32124;">Kirim Pendaftaran</button>
            </div>
        </div>
    </div>
</div>

<script>
    const isTeamLeader = @json($isTeamLeader);
    let selectedPlayers = []; // Menyimpan ID pemain yang dipilih
    const MAX_PLAYERS = 13;

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch List Events
        fetch('{{ route("api.events-frontend") }}')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    const container = document.getElementById('events-container');
                    let html = '';

                    data.data.forEach(event => {
                        let registerBtn = isTeamLeader
                            ? `<div class="center" style="margin-top:15px;"><button class="btn btn-danger btn-block" onclick="openRegisterModal('${event.id}', '${event.name.replace(/'/g, "\\'")}')">Daftar Event</button></div>`
                            : '';

                        html += `
                            <div class="col-md-3 col-sm-6 mb-4" style="margin-bottom: 20px;">
                                <div class="card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px; border-radius: 8px;">
                                    <img class="img-responsive" src="/images/upload/${event.logo}" alt="${event.name}" style="width:100%; height: 200px; object-fit: cover; border-radius: 6px;">
                                    <div style="margin-top: 15px;">
                                        <h4 style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${event.name}">${event.name}</h4>
                                        <p style="margin-bottom: 5px; font-size: 13px; color: #555;"><i class="fa fa-calendar"></i> Mulai: ${event.start_date}</p>
                                        <p style="margin-bottom: 5px; font-size: 13px; color: #555;"><i class="fa fa-calendar-times-o"></i> Berakhir: ${event.end_date}</p>
                                        ${registerBtn}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                } else {
                    document.getElementById('events-container').innerHTML = '<div class="col-md-12 text-center"><p>Belum ada event yang tersedia saat ini.</p></div>';
                }
            })
            .catch(error => {
                document.getElementById('events-container').innerHTML = '<div class="col-md-12 text-center text-danger"><p>Gagal memuat event.</p></div>';
            });
    });

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
        fetch('{{ route("team_leader.get_members") }}')
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

    // 2. FUNGSI CHECKBOX (Limit maksimal 13)
    function handleCheckbox(checkbox) {
        if (checkbox.checked) {
            if (selectedPlayers.length >= MAX_PLAYERS) {
                checkbox.checked = false; // Batalkan centang
                alert(`Anda hanya dapat memilih maksimal ${MAX_PLAYERS} pemain.`);
                return;
            }
            selectedPlayers.push(checkbox.value);
        } else {
            selectedPlayers = selectedPlayers.filter(id => id !== checkbox.value);
        }

        // Update Counter
        document.getElementById('selectionCounter').innerText = `${selectedPlayers.length}/${MAX_PLAYERS} Terpilih`;

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
        if (selectedPlayers.length !== 1) {
            alert('Needs 13 Players!');
            return;
        }

        const btnSubmit = document.getElementById('btnSubmitRegister');
        btnSubmit.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
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
            btnSubmit.innerHTML = 'Kirim Pendaftaran';
            btnSubmit.disabled = false;

            if (data.success) {
                alert('Pendaftaran berhasil dikirim!');
                $('#registerEventModal').modal('hide');
            } else {
                alert(data.message || 'Terjadi kesalahan saat mendaftar.');
            }
        })
        .catch(err => {
            btnSubmit.innerHTML = 'Kirim Pendaftaran';
            btnSubmit.disabled = false;
            alert('Gagal terhubung ke server. Silakan coba lagi.');
        });
    }
</script>
@endsection
