@extends('views_backend.layouts.app')

@section('title', 'Edit Group - LayApp')

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
        <h1 class="fs-3 mb-1">Edit Group</h1>
        <p class="mb-0">Update group details</p>
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

        <form action="{{ route('group.update', $groupEvent->id) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Resolve current event_id and team_id from the eventRegistration relationship --}}
          @php
            $currentEventId = $groupEvent->eventRegistration->event_id ?? null;
            $currentTeamId  = $groupEvent->eventRegistration->team_id  ?? null;
          @endphp

          <!-- Event Selection -->
          <div class="mb-4">
            <label for="event_id" class="form-label">Event Name</label>
            <select name="event_id" id="event_id" class="form-select" required>
              <option value="">Select an event</option>
              @foreach ($events as $event)
                <option value="{{ $event->id }}"
                  {{ old('event_id', $currentEventId) == $event->id ? 'selected' : '' }}>
                  {{ $event->name }}
                </option>
              @endforeach
            </select>
            @error('event_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Group Game -->
          <div class="mb-4">
            <label for="group_game_id" class="form-label">Group Game</label>
            <select name="group_game_id" id="group_game_id" class="form-select" required>
              <option value="">Select a group game</option>
              @foreach ($groupGames as $groupGame)
                <option value="{{ $groupGame->id }}"
                  {{ old('group_game_id', $groupEvent->group_game_id) == $groupGame->id ? 'selected' : '' }}>
                  {{ $groupGame->name }}
                </option>
              @endforeach
            </select>
            @error('group_game_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Team Name -->
          <div class="mb-4">
            <label for="team_id" class="form-label">Team Name</label>
            <select name="team_id" id="team_id" class="form-select" required>
              <option value="">Select a team</option>
              @foreach ($teams as $team)
                <option value="{{ $team->id }}"
                  {{ old('team_id', $currentTeamId) == $team->id ? 'selected' : '' }}>
                  {{ $team->name }}
                </option>
              @endforeach
            </select>
            @error('team_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
          </div>

          <!-- Play -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="play" class="form-label">Play</label>
              <input type="number" class="form-control" id="play" name="play"
                value="{{ old('play', $groupEvent->play) }}" min="0" required>
              @error('play')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Win -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="win" class="form-label">Win</label>
              <input type="number" class="form-control" id="win" name="win"
                value="{{ old('win', $groupEvent->win) }}" min="0" required>
              @error('win')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Lose -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="lose" class="form-label">Lose</label>
              <input type="number" class="form-control" id="lose" name="lose"
                value="{{ old('lose', $groupEvent->lose) }}" min="0" required>
              @error('lose')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Draw -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="draw" class="form-label">Draw</label>
              <input type="number" class="form-control" id="draw" name="draw"
                value="{{ old('draw', $groupEvent->draw) }}" min="0" required>
              @error('draw')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Point -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="point" class="form-label">Point</label>
              <input type="number" class="form-control" id="point" name="point"
                value="{{ old('point', $groupEvent->point) }}" min="0" required>
              @error('point')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Group</button>
            <a href="{{ route('group-list') }}" class="btn btn-secondary">Cancel</a>
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
    new TomSelect('#event_id', { create: false });
    new TomSelect('#group_game_id', { create: false });
    new TomSelect('#team_id', { create: false });
});
</script>
@endpush
