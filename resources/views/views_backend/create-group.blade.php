@extends('views_backend.layouts.app')

@section('title', 'Create Group - LayApp')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
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

<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Create Group</h1>
        <p class="mb-0">Manage your groups</p>
      </div>
      <div>
        <a class="btn btn-primary" href="{{ route('group-list') }}">Go to Groups List</a>
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

        <form action="{{ route('group.store') }}" method="POST">
          @csrf

          <!-- Group Game -->
          <div class="mb-4">
            <label for="group_game_id" class="form-label">Group Game</label>
            <select name="group_game_id" id="group_game_id" class="form-select" required>
              <option value="">Select a group game</option>
              @foreach ($groupGames as $groupGame)
                <option value="{{ $groupGame->id }}" {{ old('group_game_id') == $groupGame->id ? 'selected' : '' }}>
                  {{ $groupGame->name }}
                </option>
              @endforeach
            </select>
            @error('group_game_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Event Selection -->
          <div class="mb-4">
            <label for="event_id" class="form-label">Event Name</label>
            <select name="event_id" id="event_id" class="form-select" required>
              <option value="">Select an event</option>
              @foreach ($events as $event)
                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                  {{ $event->name }}
                </option>
              @endforeach
            </select>
            @error('event_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Team Name -->
          <div class="mb-4">
            <label for="team_id" class="form-label">Team Name</label>
            <select name="team_id" id="team_id" class="form-select" required>
              <option value="">Select a team</option>
              @foreach ($teams as $team)
                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                  {{ $team->name }}
                </option>
              @endforeach
            </select>
            @error('team_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Play, Win, Lose, Draw, Point -->
          <div class="row">
            <div class="col-md-2 mb-3">
              <label for="play" class="form-label">Play</label>
              <input type="number" class="form-control" id="play" name="play" value="{{ old('play', 0) }}" min="0" required>
              @error('play')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="win" class="form-label">Win</label>
              <input type="number" class="form-control" id="win" name="win" value="{{ old('win', 0) }}" min="0" required>
              @error('win')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="lose" class="form-label">Lose</label>
              <input type="number" class="form-control" id="lose" name="lose" value="{{ old('lose', 0) }}" min="0" required>
              @error('lose')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="draw" class="form-label">Draw</label>
              <input type="number" class="form-control" id="draw" name="draw" value="{{ old('draw', 0) }}" min="0" required>
              @error('draw')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="point" class="form-label">Point</label>
              <input type="number" class="form-control" id="point" name="point" value="{{ old('point', 0) }}" min="0" required>
              @error('point')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Add Group</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
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
document.addEventListener('DOMContentLoaded', function() {
    new TomSelect('#event_id', { create: false, maxItems: 1, plugins: ['clear_button'] });
    new TomSelect('#group_game_id', { create: false, maxItems: 1, plugins: ['clear_button'] });
    new TomSelect('#team_id', { create: false, maxItems: 1, plugins: ['clear_button'] });

    // Clear button
    document.querySelectorAll("form").forEach((formElement) => {
        formElement.addEventListener("reset", (event) => {
        event.target
            .querySelectorAll(".tomselected")
            .forEach((tomselectedElement) => {
            tomselectedElement.tomselect.clear();
            });
        });
    })
});
</script>
@endpush
