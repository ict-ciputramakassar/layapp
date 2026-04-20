@extends('views_backend.layouts.app')

@section('title', 'Create Schedule - LayApp')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .error-text {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    .error-text.show {
        display: block;
    }

    /* Custom Orange Focus for Inputs and TomSelect */
    .form-control:focus, .form-select:focus, .ts-wrapper.focus {
        border-color: rgba(253, 126, 20, 0.5) !important;
        box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0.25) !important;
        outline: none !important;
    }
    .ts-wrapper.focus .ts-control {
        border-color: rgba(253, 126, 20, 0.5) !important;
        box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0) !important;
    }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Create Schedule</h1>
        <p class="mb-0">Manage your schedules</p>
      </div>
      <div>
        <a class="btn btn-primary" href="{{ route('schedule-list') }}">Go to Schedules List</a>
      </div>
    </div>
  </div>
</div>

<!-- Add Schedule Form Card -->
<div class="row">
  <div class="col-lg-12 col-12">
    <div class="card">
      <div class="card-body p-5">
        <h2 class="fs-5 mb-4">Add Schedule</h2>

        <form id="scheduleForm" novalidate>
          @csrf

          <!-- Event Name -->
          <div class="mb-4">
            <label for="eventName" class="form-label">Event Name</label>
            <select name="event_id" id="eventName" class="form-select" required>
              <option value="" disabled selected>Select an event..</option>
              @foreach($events as $event)
              <option value="{{ $event->id }}">{{ $event->name }}</option>
              @endforeach
            </select>
            <div class="error-text" id="eventError"></div>
          </div>

          <!-- Team Schedule Header & Add Row Button -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Team Schedule</h6>
            <button type="button" id="addRowButton" class="btn btn-outline-primary btn-sm">
              <i class="ti ti-plus"></i> Add Row
            </button>
          </div>

          <!-- Team Schedule Table -->
          <div class="table-responsive border mb-4">
            <table class="table table-hover align-middle mb-0" id="scheduleTable">
                <thead class="table-light border-bottom">
                    <tr>
                        <th style="width: 35%;" class="fw-semibold">Team Home</th>
                        <th class="text-center" style="width: 5%;"></th>
                        <th style="width: 35%;" class="fw-semibold">Team Away</th>
                        <th style="width: 15%;" class="fw-semibold">Play Date</th>
                        <th class="text-center fw-semibold" style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody id="scheduleTableBody">
                    <tr class="schedule-row">
                        <td>
                            <select name="team_id_h" class="form-select team-select" required>
                                <option value="" disabled selected>Select Team..</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center fw-bold">VS</td>
                        <td>
                            <select name="team_id_a" class="form-select team-select" required>
                                <option value="" disabled selected>Select Team..</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="datetime-local" class="form-control" name="play_date" required>
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger delete-row">
                                <i class="ti ti-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="error-text px-3 pb-3" id="scheduleError"></div>
          </div>

          <!-- Submit Buttons -->
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Schedule</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<div class="row">
  <div class="col-12">
    <footer class="text-center py-2 mt-6 text-secondary">
      <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://wyattmatt.github.io/" target="_blank" class="text-primary">WyattMatt</a></p>
    </footer>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
(() => {
    const teams = @json($teams);

    function initScheduleForm() {
        const scheduleForm = document.getElementById('scheduleForm');
        const addRowButton = document.getElementById('addRowButton');
        const scheduleTableBody = document.getElementById('scheduleTableBody');
        const eventSelect = document.getElementById('eventName');

        if (!scheduleForm || !addRowButton || !scheduleTableBody || !eventSelect) {
            return;
        }

        // Prevent duplicate event binding on dynamic page loads.
        if (scheduleForm.dataset.initialized === 'true') {
            return;
        }
        scheduleForm.dataset.initialized = 'true';
        // Initialize search dropdowns
        if (eventSelect) {
            new TomSelect(eventSelect, { create: false });
        }
        document.querySelectorAll('.team-select').forEach(el => {
            new TomSelect(el, { create: false, dropdownParent: 'body' });
        });

        function getTeamOptions() {
            let options = '<option value="">Select Team</option>';
            teams.forEach(team => {
                options += `<option value="${team.id}">${team.name}</option>`;
            });
            return options;
        }

        function createScheduleRow() {
            const newRow = document.createElement('tr');
            newRow.className = 'schedule-row';
            newRow.innerHTML = `
                <td><select name="team_id_h" class="form-select team-select" required>${getTeamOptions()}</select></td>
                <td class="text-center fw-bold">VS</td>
                <td><select name="team_id_a" class="form-select team-select" required>${getTeamOptions()}</select></td>
                <td><input type="datetime-local" class="form-control" name="play_date" required></td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger delete-row">
                        <i class="ti ti-trash"></i> Delete
                    </a>
                </td>
            `;
            scheduleTableBody.appendChild(newRow);

            // Initialize Tom Select for new row
            newRow.querySelectorAll('.team-select').forEach(el => {
                new TomSelect(el, { create: false, dropdownParent: 'body' });
            });
        }

        addRowButton.addEventListener('click', function(e) {
            e.preventDefault();
            createScheduleRow();
        });

        // Delegate clicks so delete works for both initial and added rows.
        document.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.delete-row');
            if (!deleteBtn || !scheduleTableBody.contains(deleteBtn)) {
                return;
            }

            e.preventDefault();
            const rows = scheduleTableBody.querySelectorAll('.schedule-row');
            if (rows.length > 1) {
                deleteBtn.closest('tr').remove();
            } else {
                alert('You must have at least one schedule row.');
            }
        });

        scheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // 1. Move the cleanup logic INSIDE the submit listener so it runs every time "Save" is clicked!
            document.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));
            document.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());

            document.getElementById('eventError').textContent = '';
            document.getElementById('eventError').classList.remove('show');
            document.getElementById('scheduleError').textContent = '';
            document.getElementById('scheduleError').classList.remove('show');

            const eventId = eventSelect.value;
            if (!eventId) {
                // 2. Apply the 'is-invalid' class to the actual Dropdown Input (or TomSelect wrapper), NOT the error div.
                const dropdownElement = eventSelect.tomselect ? eventSelect.tomselect.wrapper : eventSelect;
                dropdownElement.classList.add("is-invalid");

                // 3. Create the Bootstrap invalid-feedback message under the dropdown
                dropdownElement.insertAdjacentHTML(
                    "afterend",
                    '<div class="invalid-feedback d-block">Please select an event.</div>'
                );
                return;
            }

            const rows = scheduleTableBody.querySelectorAll('.schedule-row');
            if (rows.length === 0) {
                document.getElementById('scheduleError').textContent = 'Please add at least one schedule.';
                document.getElementById('scheduleError').classList.add('show');
                return;
            }

            const schedules = [];
            let isValid = true;

            rows.forEach((row, index) => {
                const teamHomeSelect = row.querySelector('[name="team_id_h"]');
                const teamAwaySelect = row.querySelector('[name="team_id_a"]');
                const playDateInput = row.querySelector('[name="play_date"]');

                const teamHome = teamHomeSelect.value;
                const teamAway = teamAwaySelect.value;
                const playDate = playDateInput.value;

                let rowValid = true;

                // 1. Check Home Team
                if (!teamHome) {
                    const el = teamHomeSelect.tomselect ? teamHomeSelect.tomselect.wrapper : teamHomeSelect;
                    el.classList.add("is-invalid");
                    rowValid = false;
                }

                // 2. Check Away Team
                if (!teamAway) {
                    const el = teamAwaySelect.tomselect ? teamAwaySelect.tomselect.wrapper : teamAwaySelect;
                    el.classList.add("is-invalid");
                    rowValid = false;
                }

                // 3. Check Date
                if (!playDate) {
                    playDateInput.classList.add("is-invalid");
                    rowValid = false;
                }

                // 4. Check for duplicate teams (only if both are filled)
                if (teamHome && teamAway && teamHome === teamAway) {
                    const elH = teamHomeSelect.tomselect ? teamHomeSelect.tomselect.wrapper : teamHomeSelect;
                    const elA = teamAwaySelect.tomselect ? teamAwaySelect.tomselect.wrapper : teamAwaySelect;
                    elH.classList.add("is-invalid");
                    elA.classList.add("is-invalid");
                    rowValid = false;

                    document.getElementById('scheduleError').textContent = `Row ${index + 1}: Home and Away teams cannot be the same.`;
                    document.getElementById('scheduleError').classList.add('show');
                } else if (!rowValid) {
                    // Update global text if fields were missing
                    document.getElementById('scheduleError').textContent = `Row ${index + 1}: Please fill all highlighted fields.`;
                    document.getElementById('scheduleError').classList.add('show');
                }

                if (!rowValid) {
                    isValid = false;
                    return; // Move to the next row in the loop
                }

                schedules.push({
                    team_id_h: teamHome,
                    team_id_a: teamAway,
                    play_date: playDate
                });
            });

            if (!isValid) return;

            const submitBtn = scheduleForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

            fetch('{{ route("schedule.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ event_id: eventId, schedules: schedules })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Request failed: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    setTimeout(() => {
                        window.location.href = '{{ route("schedule-list") }}';
                    }, 1000);
                } else {
                    document.getElementById('scheduleError').textContent = data.message || 'Failed to save schedule.';
                    document.getElementById('scheduleError').classList.add('show');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Schedule';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('scheduleError').textContent = 'An error occurred.';
                document.getElementById('scheduleError').classList.add('show');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Schedule';
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScheduleForm);
    } else {
        initScheduleForm();
    }
})();
</script>
@endpush
