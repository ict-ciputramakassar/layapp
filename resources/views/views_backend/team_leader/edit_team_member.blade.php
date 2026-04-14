@extends('views_backend.layouts.app')

@section('title', 'Edit Team Member - LayApp')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="">
          <h1 class="fs-3 mb-1">Edit Member</h1>
          <p class="mb-0">Update information for {{ $member->full_name }}</p>
        </div>
        <div>
          <a href="{{ route('team_leader.team_members') }}" class="btn btn-outline-primary">Back to Member List</a>
        </div>
      </div>
    </div>
  </div>

  <!-- FORM SECTION -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-4">
          <form id="editMemberForm">
            <!-- Hidden ID for Update URL -->
            <input type="hidden" id="member_id" value="{{ $member->id }}">

            <div class="col-md-12 mb-3">
              <label for="member_type_id" class="form-label">Member Type</label>
              <select class="form-select" id="member_type_id" name="member_type_id" required>
                <option value="" disabled>Select Type</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}" data-code="{{ $type->code }}" {{ $member->member_type_id == $type->id ? 'selected' : '' }}>
                    {{ $type->code }} - {{ $type->name }}
                  </option>
                @endforeach
              </select>
              <!-- Hidden input for type_code -->
              <input type="hidden" name="type_code" id="type_code">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label">Member Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $member->full_name }}"
                  required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob"
                  value="{{ \Carbon\Carbon::parse($member->dob)->format('Y-m-d') }}" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                  value="{{ $member->phone_number }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Member Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="height" class="form-label">Member Height</label>
                <input type="number" class="form-control" id="height" name="height" value="{{ $member->height }}"
                  required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="weight" class="form-label">Member Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" value="{{ $member->weight }}"
                  required>
              </div>
            </div>

            <!-- COACH INPUTS -->
            <div class="row d-none" id="coach-inputs">
              <div class="col-md-6 mb-3">
                <label for="license" class="form-label">License</label>
                <input type="text" class="form-control" id="license" name="license" value="{{ $member->license }}"
                  maxlength="1" placeholder="A">
              </div>
              <div class="col-md-6 mb-3">
                <label for="valid_date" class="form-label">License Valid Date</label>
                <input type="date" class="form-control" id="valid_date" name="valid_date"
                  value="{{ $member->valid_date ? \Carbon\Carbon::parse($member->valid_date)->format('Y-m-d') : '' }}">
              </div>
            </div>

            <!-- PLAYER INPUTS -->
            <div class="row d-none" id="player-inputs">
              <div class="col-md-6 mb-3">
                <label for="position_id" class="form-label">Member Position</label>
                <select class="form-select" id="position_id" name="position_id">
                  <option value="" disabled selected>Select Position</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}" {{ $member->position_id == $position->id ? 'selected' : '' }}>
                      {{ $position->code }} - {{ $position->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="category_age_id" class="form-label">Member Age</label>
                <select class="form-select" id="category_age_id" name="category_age_id">
                  <option value="" disabled selected>Select Age Category</option>
                  @foreach ($age_categories as $age_category)
                    <option value="{{ $age_category->id }}" {{ $member->category_age_id == $age_category->id ? 'selected' : '' }}>
                      {{ $age_category->code }} - {{ $age_category->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="mb-4">
              <label for="image" class="form-label">Member Image</label>
              <div class="d-flex align-items-center gap-3 mb-2">
                @if($member->image)
                  <img src="{{ asset($member->image) }}" alt="Current Image" class="rounded border"
                    style="width: 60px; height: 60px; object-fit: cover;">
                @else
                  <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted"
                    style="width: 60px; height: 60px; font-size: 12px;">No Img</div>
                @endif
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
              </div>
              <small class="text-muted">Leave blank if you don't want to change the current image.</small>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary" id="submitBtn">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <footer class="text-center py-2 mt-6 text-secondary ">
        <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard.</p>
      </footer>
    </div>
  </div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editMemberForm');
    const submitBtn = document.getElementById('submitBtn');

    // ==========================================
    // DYNAMIC INPUTS LOGIC (COACH vs PLAYER)
    // ==========================================
    function handleTypeChange() {
      const selectElement = document.getElementById('member_type_id');
      if (!selectElement || selectElement.selectedIndex === -1) return;

      const selectedOption = selectElement.options[selectElement.selectedIndex];
      const code = selectedOption.getAttribute('data-code') || '';
      const firstTwoLetters = code.substring(0, 2).toUpperCase();

      // Set hidden input value
      document.getElementById('type_code').value = firstTwoLetters;

      // Containers
      const coachContainer = document.getElementById('coach-inputs');
      const playerContainer = document.getElementById('player-inputs');

      // Coach Inputs
      const licenseInput = document.getElementById('license');
      const validDateInput = document.getElementById('valid_date');

      // Player Inputs
      const positionInput = document.getElementById('position_id');
      const ageInput = document.getElementById('category_age_id');

      if (firstTwoLetters === 'AT') {
        // Show Player, Hide Coach
        playerContainer.classList.remove('d-none');
        coachContainer.classList.add('d-none');

        // Set Required
        positionInput.required = true;
        ageInput.required = true;
        licenseInput.required = false;
        validDateInput.required = false;

      } else if (firstTwoLetters === 'CO') {
        // Show Coach, Hide Player
        coachContainer.classList.remove('d-none');
        playerContainer.classList.add('d-none');

        // Set Required
        licenseInput.required = true;
        validDateInput.required = true;
        positionInput.required = false;
        ageInput.required = false;

      } else {
        // Hide Both
        coachContainer.classList.add('d-none');
        playerContainer.classList.add('d-none');

        licenseInput.required = false;
        validDateInput.required = false;
        positionInput.required = false;
        ageInput.required = false;
      }
    }

    // Event Listener for Dropdown
    document.getElementById('member_type_id').addEventListener('change', handleTypeChange);

    // TRIGGER ON PAGE LOAD (To show correct fields based on database value)
    handleTypeChange();

    // ==========================================
    // SUBMIT FORM VIA AJAX
    // ==========================================
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const memberId = document.getElementById('member_id').value;
      const formData = new FormData(form);

      // Laravel requires _method=PUT for file uploads in PUT requests
      formData.append('_method', 'PUT');

      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = 'Saving...';
      submitBtn.disabled = true;

      // Ganti URL ini dengan nama route update Anda
      let updateUrl = "{{ route('team_leader.update_member', ':id') }}".replace(':id', memberId);

      fetch(updateUrl, {
        method: 'POST', // Tetap POST karena kita pakai _method=PUT di formData
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: formData
      })
        .then(async response => {
          const data = await response.json();
          if (!response.ok) {
            if (response.status === 422) {
              let errorString = 'Validation Error:\n';
              for (const [key, value] of Object.entries(data.errors)) {
                errorString += `- ${value[0]}\n`;
              }
              throw new Error(errorString);
            }
            throw new Error(data.message || 'Something went wrong.');
          }
          return data;
        })
        .then(data => {
          if (data.success) {
            alert(data.message);
            // Redirect ke halaman list member
            window.location.href = "{{ route('team_leader.team_members') }}";
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert(error.message);
        })
        .finally(() => {
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        });
    });
  });
</script>