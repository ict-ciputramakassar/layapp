@extends('views_backend.layouts.app')

@section('title', 'Add Team Member - LayApp')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="">
          <h1 class="fs-3 mb-1">Add Member</h1>
          <p class="mb-0">Manage your team members</p>
        </div>
        <div>
          <a href="{{ route('team_leader.team_members') }}" class="btn btn-outline-primary">Go to Member List</a>
        </div>
      </div>
    </div>
  </div>

  <!-- FORM SECTION -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-4">
          <form id="addMemberForm">
            <div class="col-md-12 mb-3">
              <label for="member_type_id" class="form-label">Member Type</label>
              <select class="form-select" id="member_type_id" name="member_type_id" required>
                <option value="" disabled selected>Select Type</option>
                @foreach ($types as $type)
                  <!-- Added data-code attribute for JS targeting -->
                  <option value="{{ $type->id }}" data-code="{{ $type->code }}">{{ $type->code }} - {{ $type->name }}</option>
                @endforeach
              </select>
              <!-- Hidden input for type_code -->
              <input type="hidden" name="type_code" id="type_code">
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label">Member Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter member name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="08xxxxxxxxxxx" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Member Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="height" class="form-label">Member Height</label>
                <input type="number" class="form-control" id="height" name="height" placeholder="180" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="weight" class="form-label">Member Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" placeholder="80" required>
              </div>
            </div>

            <!-- COACH INPUTS -->
            <div class="row d-none" id="coach-inputs">
              <div class="col-md-6 mb-3">
                <label for="license" class="form-label">License</label>
                <input type="text" class="form-control" id="license" name="license" placeholder="A" maxlength="1">
              </div>
              <div class="col-md-6 mb-3">
                <label for="valid_date" class="form-label">License Valid Date</label>
                <input type="date" class="form-control" id="valid_date" name="valid_date">
              </div>
            </div>

            <!-- PLAYER INPUTS -->
            <div class="row d-none" id="player-inputs">
              <div class="col-md-6 mb-3">
                <label for="position_id" class="form-label">Member Position</label>
                <select class="form-select" id="position_id" name="position_id">
                  <option value="" disabled selected>Select Position</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->code }} - {{ $position->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="category_age_id" class="form-label">Member Age</label>
                <select class="form-select" id="category_age_id" name="category_age_id">
                  <option value="" disabled selected>Select Age Category</option>
                  @foreach ($age_categories as $age_category)
                    <option value="{{ $age_category->id }}">{{ $age_category->code }} - {{ $age_category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="image" class="form-label">Member Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Add to Temporary List</button>
              <button type="reset" class="btn btn-secondary" id="resetFormBtn">Clear</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- TEMPORARY TABLE SECTION -->
  <div class="row mt-4" id="tempTableContainer" style="display: none;">
    <div class="col-12">
      <div class="card border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0 text-white">Temporary Member List</h5>
          <span class="badge bg-light text-primary" id="memberCount">0</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Position</th>
                  <th>Type</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tempTableBody">
                <!-- Data will be injected here via JS -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer text-end">
          <button type="button" id="saveToDatabaseBtn" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Save All to Database
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <footer class="text-center py-2 mt-6 text-secondary ">
        <p class="mb-0">Copyright © 2026 InApp Inventory Dashboard. Developed by <a href="https://codescandy.com/"
            target="_blank" class="text-primary">CodesCandy</a> • Distributed by <a href="https://themewagon.com/"
            target="_blank" class="text-primary">ThemeWagon</a> </p>
      </footer>
    </div>
  </div>

  <!-- MODAL EDIT MEMBER -->
  <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMemberModalLabel">Edit Temporary Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editMemberForm">
          <div class="modal-body">
            <input type="hidden" id="edit_id"> <!-- Hidden ID -->

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Name</label>
                <input type="text" class="form-control" id="edit_full_name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="edit_dob" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="edit_phone_number" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Email</label>
                <input type="email" class="form-control" id="edit_email" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Height</label>
                <input type="number" class="form-control" id="edit_height" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Weight</label>
                <input type="number" class="form-control" id="edit_weight" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 mb-3">
                <label class="form-label">Member Type</label>
                <select class="form-select" id="edit_member_type_id" required>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" data-code="{{ $type->code }}">{{ $type->code }} - {{ $type->name }}</option>
                  @endforeach
                </select>
                <!-- Hidden input for edit_type_code -->
                <input type="hidden" id="edit_type_code">
              </div>
            </div>

            <!-- EDIT COACH INPUTS WRAPPER -->
            <div class="row d-none" id="edit_coach-inputs">
              <div class="col-md-6 mb-3">
                <label class="form-label">License</label>
                <input type="text" class="form-control" id="edit_license" maxlength="1">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">License Valid Date</label>
                <input type="date" class="form-control" id="edit_valid_date">
              </div>
            </div>

            <!-- EDIT PLAYER INPUTS WRAPPER -->
            <div class="row d-none" id="edit_player-inputs">
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Position</label>
                <select class="form-select" id="edit_position_id">
                  <option value="" disabled selected>Select Position</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->code }} - {{ $position->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Member Age</label>
                <select class="form-select" id="edit_category_age_id">
                  <option value="" disabled selected>Select Age Category</option>
                  @foreach ($age_categories as $age_category)
                    <option value="{{ $age_category->id }}">{{ $age_category->code }} - {{ $age_category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Member Image <span class="text-danger" style="font-size: 12px;">(Leave blank to
                  keep current image: <span id="current_image_name"></span>)</span></label>
              <input type="file" class="form-control" id="edit_image" accept="image/*">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Member</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END MODAL -->

  <script>
    let tempMembers = [];
    let editModalInstance = null;

    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('addMemberForm');
      const tempTableContainer = document.getElementById('tempTableContainer');
      const tempTableBody = document.getElementById('tempTableBody');
      const saveToDatabaseBtn = document.getElementById('saveToDatabaseBtn');
      const memberCount = document.getElementById('memberCount');
      const editForm = document.getElementById('editMemberForm');
      const resetBtn = document.getElementById('resetFormBtn');

      // Initialize Bootstrap Modal
      editModalInstance = new bootstrap.Modal(document.getElementById('editMemberModal'));

      // ==========================================
      // DYNAMIC INPUTS LOGIC (COACH vs PLAYER)
      // ==========================================
      function handleTypeChange(selectId, prefix = '') {
        const selectElement = document.getElementById(selectId);
        if (!selectElement || selectElement.selectedIndex === -1) return;

        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const code = selectedOption.getAttribute('data-code') || '';
        const firstTwoLetters = code.substring(0, 2).toUpperCase();
        
        // Dynamically set the hidden input value (works for both 'type_code' and 'edit_type_code')
        const hiddenTypeCodeInput = document.getElementById(prefix + 'type_code');
        if (hiddenTypeCodeInput) {
            hiddenTypeCodeInput.value = firstTwoLetters;
        }

        // Containers
        const coachContainer = document.getElementById(prefix + 'coach-inputs');
        const playerContainer = document.getElementById(prefix + 'player-inputs');

        // Coach Inputs
        const licenseInput = document.getElementById(prefix + 'license');
        const validDateInput = document.getElementById(prefix + 'valid_date');

        // Player Inputs
        const positionInput = document.getElementById(prefix + 'position_id');
        const ageInput = document.getElementById(prefix + 'category_age_id');

        if (firstTwoLetters === 'AT') {
          // Show Player, Hide Coach
          playerContainer.classList.remove('d-none');
          coachContainer.classList.add('d-none');

          // Set Required
          positionInput.required = true;
          ageInput.required = true;
          licenseInput.required = false;
          validDateInput.required = false;

          // Clear hidden values
          licenseInput.value = '';
          validDateInput.value = '';

        } else if (firstTwoLetters === 'CO') {
          // Show Coach, Hide Player
          coachContainer.classList.remove('d-none');
          playerContainer.classList.add('d-none');

          // Set Required
          licenseInput.required = true;
          validDateInput.required = true;
          positionInput.required = false;
          ageInput.required = false;

          // Clear hidden values
          positionInput.value = '';
          ageInput.value = '';

        } else {
          // Hide Both (Default state)
          coachContainer.classList.add('d-none');
          playerContainer.classList.add('d-none');

          licenseInput.required = false;
          validDateInput.required = false;
          positionInput.required = false;
          ageInput.required = false;
        }
      }

      // Event Listeners for Dropdowns
      document.getElementById('member_type_id').addEventListener('change', function() {
        handleTypeChange('member_type_id', '');
      });

      document.getElementById('edit_member_type_id').addEventListener('change', function() {
        handleTypeChange('edit_member_type_id', 'edit_');
      });

      // Trigger on Page Load
      handleTypeChange('member_type_id', '');

      // Handle Form Reset Button
      resetBtn.addEventListener('click', function() {
        setTimeout(() => {
          handleTypeChange('member_type_id', '');
        }, 10);
      });
      // ==========================================


      // 1. ADD MEMBER TO TABLE
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const imageFile = document.getElementById('image').files[0];

        const positionSelect = document.getElementById('position_id');
        const positionText = positionSelect.value ? positionSelect.options[positionSelect.selectedIndex].text : '-';

        const typeSelect = document.getElementById('member_type_id');
        const typeText = typeSelect.options[typeSelect.selectedIndex].text;

        const member = {
          id: Date.now(),
          full_name: formData.get('full_name'),
          dob: formData.get('dob'),
          phone_number: formData.get('phone_number'),
          email: formData.get('email'),
          height: formData.get('height'),
          weight: formData.get('weight'),
          license: formData.get('license') || '',
          valid_date: formData.get('valid_date') || '',
          member_type_id: formData.get('member_type_id'),
          type_code: formData.get('type_code'), // Captured from hidden input
          member_type_text: typeText,
          position_id: formData.get('position_id') || '',
          position_text: positionText,
          category_age_id: formData.get('category_age_id') || '',
          imageFile: imageFile,
          imageName: imageFile ? imageFile.name : 'No Image'
        };

        tempMembers.push(member);
        renderTable();
        form.reset();
        handleTypeChange('member_type_id', ''); 
      });

      // 2. RENDER TABLE
      function renderTable() {
        tempTableBody.innerHTML = '';

        if (tempMembers.length > 0) {
          tempTableContainer.style.display = 'block';
          memberCount.innerText = tempMembers.length;

          tempMembers.forEach((member) => {
            const row = `
                    <tr>
                      <td>${member.full_name}</td>
                      <td>${member.email}</td>
                      <td><span class="badge bg-secondary">${member.position_text}</span></td>
                      <td>${member.member_type_text}</td>
                      <td>${member.imageName}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning me-1" onclick="openEditModal(${member.id})">
                          Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeMember(${member.id})">
                          Remove
                        </button>
                      </td>
                    </tr>
                  `;
            tempTableBody.insertAdjacentHTML('beforeend', row);
          });
        } else {
          tempTableContainer.style.display = 'none';
        }
      }

      // 3. REMOVE MEMBER
      window.removeMember = function (id) {
        tempMembers = tempMembers.filter(member => member.id !== id);
        renderTable();
      };

      // 4. OPEN EDIT MODAL
      window.openEditModal = function (id) {
        const member = tempMembers.find(m => m.id === id);
        if (!member) return;

        document.getElementById('edit_id').value = member.id;
        document.getElementById('edit_full_name').value = member.full_name;
        document.getElementById('edit_dob').value = member.dob;
        document.getElementById('edit_phone_number').value = member.phone_number;
        document.getElementById('edit_email').value = member.email;
        document.getElementById('edit_height').value = member.height;
        document.getElementById('edit_weight').value = member.weight;
        document.getElementById('edit_license').value = member.license;
        document.getElementById('edit_valid_date').value = member.valid_date;
        document.getElementById('edit_member_type_id').value = member.member_type_id;
        document.getElementById('edit_type_code').value = member.type_code; // Set hidden input
        document.getElementById('edit_position_id').value = member.position_id;
        document.getElementById('edit_category_age_id').value = member.category_age_id;

        document.getElementById('current_image_name').innerText = member.imageName;
        document.getElementById('edit_image').value = '';

        // Trigger dynamic inputs logic for the modal
        handleTypeChange('edit_member_type_id', 'edit_');

        editModalInstance.show();
      };

      // 5. SUBMIT EDIT FORM
      editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const id = parseInt(document.getElementById('edit_id').value);
        const index = tempMembers.findIndex(m => m.id === id);

        if (index !== -1) {
          tempMembers[index].full_name = document.getElementById('edit_full_name').value;
          tempMembers[index].dob = document.getElementById('edit_dob').value;
          tempMembers[index].phone_number = document.getElementById('edit_phone_number').value;
          tempMembers[index].email = document.getElementById('edit_email').value;
          tempMembers[index].height = document.getElementById('edit_height').value;
          tempMembers[index].weight = document.getElementById('edit_weight').value;
          tempMembers[index].license = document.getElementById('edit_license').value;
          tempMembers[index].valid_date = document.getElementById('edit_valid_date').value;

          const typeSelect = document.getElementById('edit_member_type_id');
          tempMembers[index].member_type_id = typeSelect.value;
          tempMembers[index].member_type_text = typeSelect.options[typeSelect.selectedIndex].text;
          tempMembers[index].type_code = document.getElementById('edit_type_code').value; // Update type_code

          const positionSelect = document.getElementById('edit_position_id');
          tempMembers[index].position_id = positionSelect.value;
          tempMembers[index].position_text = positionSelect.value ? positionSelect.options[positionSelect.selectedIndex].text : '-';

          const ageSelect = document.getElementById('edit_category_age_id');
          tempMembers[index].category_age_id = ageSelect.value;

          const newImageFile = document.getElementById('edit_image').files[0];
          if (newImageFile) {
            tempMembers[index].imageFile = newImageFile;
            tempMembers[index].imageName = newImageFile.name;
          }

          renderTable();
          editModalInstance.hide();
        }
      });

      // 6. SUBMIT ALL TO DATABASE
      saveToDatabaseBtn.addEventListener('click', function () {
        if (tempMembers.length === 0) {
          alert('Table is empty!');
          return;
        }

        const serverFormData = new FormData();

        tempMembers.forEach((member, index) => {
          serverFormData.append(`members[${index}][full_name]`, member.full_name);
          serverFormData.append(`members[${index}][dob]`, member.dob);
          serverFormData.append(`members[${index}][phone_number]`, member.phone_number);
          serverFormData.append(`members[${index}][email]`, member.email);
          serverFormData.append(`members[${index}][height]`, member.height);
          serverFormData.append(`members[${index}][weight]`, member.weight);
          serverFormData.append(`members[${index}][license]`, member.license);
          serverFormData.append(`members[${index}][valid_date]`, member.valid_date);
          serverFormData.append(`members[${index}][member_type_id]`, member.member_type_id);
          serverFormData.append(`members[${index}][type_code]`, member.type_code); // Sending type_code to backend
          serverFormData.append(`members[${index}][position_id]`, member.position_id);
          serverFormData.append(`members[${index}][category_age_id]`, member.category_age_id);
          serverFormData.append(`members[${index}][image]`, member.imageFile);
        });

        const originalText = saveToDatabaseBtn.innerHTML;
        saveToDatabaseBtn.innerHTML = 'Saving...';
        saveToDatabaseBtn.disabled = true;

        fetch("{{ route('team_leader.add_members_bulk') }}", {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: serverFormData
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
              alert('All members saved successfully!');
              tempMembers = [];
              renderTable();
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert(error.message);
          })
          .finally(() => {
            saveToDatabaseBtn.innerHTML = originalText;
            saveToDatabaseBtn.disabled = false;
          });
      });
    });
  </script>
@endsection