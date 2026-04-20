@extends('views_backend.layouts.app')

@section('title', 'Add Event - LayApp')

@section('content')

<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Add Event</h1>
        <p class="mb-0">Manage your events</p>
      </div>
      <div>
        <a class="btn btn-primary" href="{{ route('event-list') }}">Go to Events List</a>
      </div>
    </div>
  </div>
</div>

<!-- Form Card -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-6">
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="mb-2">Please fix the following errors:</h6>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Event Name -->
          <div class="mb-3">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" class="form-control @error('eventName') is-invalid @enderror" id="eventName" name="eventName" placeholder="Enter event name" value="{{ old('eventName') }}" required>
            @error('eventName')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Start Date & End Date -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="startDate" class="form-label">Start Date</label>
              <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate" value="{{ old('startDate') }}" required>
              @error('startDate')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="endDate" class="form-label">End Date</label>
              <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate" value="{{ old('endDate') }}" required>
              @error('endDate')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Description</label>
            <textarea class="form-control @error('eventDescription') is-invalid @enderror" id="eventDescription" name="eventDescription" rows="4" placeholder="Enter event description">{{ old('eventDescription') }}</textarea>
            @error('eventDescription')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Category Level -->
          <div class="mb-3">
            <label for="categoryLevel" class="form-label">Category Level</label>
            <select class="form-select @error('categoryLevel') is-invalid @enderror" id="categoryLevel" name="categoryLevel">
              <option value="">Select category level</option>
              @foreach ($categoryLevels as $level)
                <option value="{{ $level->id }}" {{ old('categoryLevel') == $level->id ? 'selected' : '' }}>
                  {{ $level->name }}
                </option>
              @endforeach
            </select>
            @error('categoryLevel')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Category Age -->
          <div class="mb-3">
            <label class="form-label">Category Age</label>
            <div class="row @error('categoryAge') is-invalid @enderror">
              @foreach ($categoryAges as $age)
                <div class="col-md-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categoryAge[]" value="{{ $age->id }}" id="categoryAge_{{ $age->id }}" {{ in_array($age->id, old('categoryAge', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="categoryAge_{{ $age->id }}">
                      {{ $age->name }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            @error('categoryAge')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Category Game -->
          <div class="mb-3">
            <label class="form-label">Category Game</label>
            <div class="row @error('categoryGame') is-invalid @enderror">
              @foreach ($categoryGames as $game)
                <div class="col-md-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categoryGame[]" value="{{ $game->id }}" id="categoryGame_{{ $game->id }}" {{ in_array($game->id, old('categoryGame', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="categoryGame_{{ $game->id }}">
                      {{ $game->name }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            @error('categoryGame')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Category Type -->
          <div class="mb-3">
            <label class="form-label">Category Type</label>
            <div class="row @error('categoryType') is-invalid @enderror">
              @foreach ($categoryTypes as $type)
                <div class="col-md-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categoryType[]" value="{{ $type->id }}" id="categoryType_{{ $type->id }}" {{ in_array($type->id, old('categoryType', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="categoryType_{{ $type->id }}">
                      {{ $type->name }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            @error('categoryType')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- EO Name -->
          <div class="mb-3">
            <label for="eoName" class="form-label">Event Organizer Name</label>
            <input type="text" class="form-control @error('eoName') is-invalid @enderror" id="eoName" name="eoName" placeholder="Enter event organizer name" value="{{ old('eoName') }}" required>
            @error('eoName')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- EO Logo -->
          <div class="mb-3">
            <label for="eoLogo" class="form-label">Event Organizer Logo</label>
            <input type="file" class="form-control @error('eoLogo') is-invalid @enderror" id="eoLogo" name="eoLogo" accept="image/*" required>
            <img id="eoLogoPreview" src="#" alt="EO Logo Preview" class="img-fluid mt-2" style="max-height: 150px; display: none;">
            <small class="form-text text-muted">Max 10MB - Supported formats: jpeg, png, jpg, gif, svg</small>
            @error('eoLogo')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Form Actions -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Add Event</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
          </div>
        </form>
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
  <script>
    // Clear EO Logo preview when reset button is clicked
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
      const preview = document.getElementById('eoLogoPreview');
      preview.src = '#';
      preview.style.display = 'none';
    });

    // EO Logo Preview
    document.getElementById('eoLogo').addEventListener('change', function(event) {
      const [file] = event.target.files;
      if (file) {
        const preview = document.getElementById('eoLogoPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
      }
    });
  </script>
@endpush
