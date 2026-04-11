@extends('views_backend.layouts.auth')

@section('title', 'Sign Up - LayApp')

@section('content')
  <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="card" style="max-width:600px; width:100%;">
      <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
          <a href="{{ route('admin.dashboard') }}" class="mb-4 d-inline-block">
            <img src="{{ asset('images/backend/logo-icon.svg') }}" alt="" width="36">
            <span class="ms-2"><img src="{{ asset('images/backend/logo.svg') }}" alt=""></span>
          </a>
          <h1 class="card-title mb-2 h5">Create your account</h1>
          <p class="text-muted small">Please fill out the form below to register</p>
        </div>

        @if($errors->any())
          <div class="alert alert-danger mb-4">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="needs-validation" method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data"
          novalidate id="signupForm">
          @csrf

          <!-- PERSONAL INFORMATION -->
          <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Personal Information</h6>

          <div class="mb-3">
            <label for="fullName" class="form-label">Full name</label>
            <input id="fullName" name="fullName" type="text" class="form-control" placeholder="Jane Doe"
              value="{{ old('fullName') }}" required>
            <div class="invalid-feedback">Please enter your name.</div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email address</label>
              <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com"
                value="{{ old('email') }}" required>
              <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="phone_number" class="form-label">Phone Number</label>
              <input id="phone_number" name="phone_number" type="tel" class="form-control" placeholder="08xxxxxxxxxxx"
                value="{{ old('phone_number') }}" required>
              <div class="invalid-feedback">Please enter a valid phone number.</div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" name="password" type="password" class="form-control" placeholder="Create password"
                required minlength="6">
              <div class="invalid-feedback">Min 6 characters.</div>
            </div>
            <div class="col-md-6 mb-4">
              <label for="confirmPassword" class="form-label">Confirm password</label>
              <input id="confirmPassword" name="confirmPassword" type="password" class="form-control"
                placeholder="Repeat password" required
                oninput="this.setCustomValidity(document.getElementById('password').value !== this.value ? 'Passwords do not match.' : '')">
              <div class="invalid-feedback">Passwords must match.</div>
            </div>
          </div>

          <hr class="mb-4">

          <!-- DROPDOWN ROLE -->
          <div class="mb-4">
            <label for="role" class="form-label fw-bold text-primary">Register As</label>
            <select id="role" name="role" class="form-select" required>
              <option value="" data-code="" disabled {{ old('role') ? '' : 'selected' }}>Select your role...</option>
              @foreach ($roles as $role)
                <option value="{{ $role->id }}" data-code="{{ $role->code }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                  {{ $role->name }}
                </option>
              @endforeach
            </select>
            <div class="invalid-feedback">Please select your role.</div>

            <!-- Hidden input untuk kode dikirim ke Controller -->
            <input type="hidden" name="role_code" id="role_code" value="{{ old('role_code') }}">
          </div>

          <!-- FORM TAMBAHAN KHUSUS TEAM LEADER -->
          <div id="teamLeaderSection" class="d-none bg-light p-4 rounded mb-4 border">
            <h6 class="mb-4 text-primary"><i class="fas fa-users me-2"></i>Team Profile Information</h6>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="team_name" class="form-label">Team Name</label>
                <input id="team_name" name="team_name" type="text" class="form-control" placeholder="Enter team name"
                  value="{{ old('team_name') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="team_phone_number" class="form-label">Team Phone</label>
                <input id="team_phone_number" name="team_phone_number" type="tel" class="form-control"
                  placeholder="08xxxxxxxxxxx" value="{{ old('team_phone_number') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="team_email" class="form-label">Team Email</label>
                <input id="team_email" name="team_email" type="email" class="form-control" placeholder="example@gmail.com"
                  value="{{ old('team_email') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="team_join_date" class="form-label">Join Date</label>
                <input id="team_join_date" name="team_join_date" type="date" class="form-control"
                  value="{{ old('team_join_date') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="team_founded_year" class="form-label">Founded Year</label>
                <input id="team_founded_year" name="team_founded_year" type="number" class="form-control"
                  placeholder="YYYY" min="1900" max="2099" value="{{ old('team_founded_year') }}">
                <div class="invalid-feedback">Enter valid year.</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="team_state" class="form-label">Team State</label>
                <input id="team_state" name="team_state" type="text" class="form-control" placeholder="Enter state"
                  value="{{ old('team_state') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="team_type_id" class="form-label">Team Type</label>
                <select id="team_type_id" name="team_type_id" class="form-select">
                  <option value="" disabled {{ old('team_type_id') ? '' : 'selected' }}>Select</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('team_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}
                    </option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Required.</div>
              </div>

              <div class="col-md-4 mb-3">
                <label for="team_province_id" class="form-label">Province</label>
                <select id="team_province_id" name="team_province_id" class="form-select">
                  <option value="" disabled {{ old('team_province_id') ? '' : 'selected' }}>Select</option>
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ old('team_province_id') == $province->id ? 'selected' : '' }}>
                      {{ $province->name }}
                    </option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Required.</div>
              </div>

              <div class="col-md-4 mb-3">
                <label for="team_city_id" class="form-label">City</label>
                <!-- Diberi disabled dari awal. Hanya aktif jika province_id ada -->
                <select id="team_city_id" name="team_city_id" class="form-select" disabled>
                  <!-- Kita gunakan old('team_city_id') di JS -->
                  <option value="" disabled selected>Select</option>
                  @foreach ($cities as $city)
                    <!-- Tambahkan data-province untuk keperluan filter di JS -->
                    <option class="city-option" value="{{ $city->id }}" data-province="{{ $city->province_id }}" {{ old('team_city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Required.</div>
              </div>

              <div class="col-md-12 mb-3">
                <label for="team_address" class="form-label">Address</label>
                <!-- Diberi disabled dari awal. Hanya aktif jika province_id ada -->
                <input type="text" id="team_address" name="team_address" class="form-control"
                  value="{{ old('team_state') }}">
                <div class="invalid-feedback">Required.</div>
              </div>
            </div>

            <div class="mb-2">
              <label for="team_image" class="form-label">Team Logo </label>
              <input type="file" class="form-control" id="team_image" name="team_image" accept="image/*">
              <!-- Info Old Value File (File upload tidak bisa otomatis keisi gara2 sekuritas browser) -->
              @if(old('team_name') && $errors->any())
                <small class="text-danger">Please re-upload your logo if you had one.</small>
              @endif
            </div>
          </div>
      </div>
      <!-- AKHIR FORM TAMBAHAN -->

      <button class="btn btn-primary w-100 py-2 fs-5" type="submit">Create Account</button>
      </form>

      <div class="text-center mt-4 small text-muted">
        Already have an account? <a href="{{ route('admin.signin') }}" class="link-primary fw-bold">Sign in</a>
      </div>
    </div>
  </div>
  </div>

  <!-- SCRIPT JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // --- LOGIKA 1: DYNAMIC ROLE & OLD VALUES ---
      const roleSelect = document.getElementById('role');
      const roleCodeInput = document.getElementById('role_code');
      const teamLeaderSection = document.getElementById('teamLeaderSection');
      const teamInputs = teamLeaderSection.querySelectorAll('input:not([type="file"]), select');

      function adaptRoleSelect() {
        if (roleSelect.selectedIndex <= 0) return; // Mencegah error jika option placeholder terpilih

        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        const roleCode = selectedOption.getAttribute('data-code');

        roleCodeInput.value = roleCode;

        if (roleCode === 'TL') {
          teamLeaderSection.classList.remove('d-none');
          teamInputs.forEach(input => input.setAttribute('required', 'required'));
        } else {
          teamLeaderSection.classList.add('d-none');
          teamInputs.forEach(input => {
            input.removeAttribute('required');
            // Catatan: Tidak saya .value = '' agar nilai lama (old) tidak terhapus saat user cuma iseng klik
          });
        }
      }

      roleSelect.addEventListener('change', adaptRoleSelect);

      // Jalankan sekali saat load, agar saat gagal validasi (old value), form tim langsung terbuka otomatis
      if (roleSelect.value !== "") {
        adaptRoleSelect();
      }

      // --- LOGIKA 2: DEPENDENT DROPDOWN (PROVINCE -> CITY) ---
      const provinceSelect = document.getElementById('team_province_id');
      const citySelect = document.getElementById('team_city_id');

      // Simpan semua opsi kota yang asli ke dalam array (untuk di-clone nanti)
      const allCityOptions = Array.from(citySelect.querySelectorAll('option.city-option'));

      function filterCities(preserveValue = false) {
        const selectedProvince = provinceSelect.value;
        const currentCityValue = citySelect.value; // Menyimpan Old Value City

        // Kosongkan select box (Hanya sisakan tulisan "Select")
        citySelect.innerHTML = '<option value="" disabled selected>Select</option>';

        if (selectedProvince) {
          // Buka kuncian Dropdown City
          citySelect.removeAttribute('disabled');

          // Loop dan masukkan kembali opsi kota yang cocok dengan provinsi
          allCityOptions.forEach(option => {
            if (option.getAttribute('data-province') === selectedProvince) {
              citySelect.appendChild(option.cloneNode(true));
            }
          });

          // Mengembalikan Old Value jika ada (saat gagal validasi / baru milih provinsi)
          if (preserveValue && currentCityValue) {
            citySelect.value = currentCityValue;
          }
        } else {
          // Kunci kembali dropdown City
          citySelect.setAttribute('disabled', 'disabled');
        }
      }

      // Event Listener saat Provinsi diganti
      provinceSelect.addEventListener('change', function () {
        filterCities(false); // Jangan pertahankan value city saat user ganti provinsi baru
      });

      // Jalankan saat load (Jika gagal validasi, Old Value dari controller akan masuk)
      if (provinceSelect.value !== "") {
        filterCities(true); // Pertahankan Old value dari City
      }

      // --- LOGIKA 3: BOOTSTRAP VALIDATION ---
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })

    });
  </script>
@endsection