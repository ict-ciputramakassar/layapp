@extends('views_backend.layouts.app')

@section('title', 'Edit Schedule - LayApp')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
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

<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Edit Schedule</h1>
        <p class="mb-0">Update schedule details</p>
      </div>
      <div>
        <a class="btn btn-primary" href="{{ route('schedule-list') }}">Go to Schedules List</a>
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

        <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Event Name -->
          <div class="mb-4">
            <label for="eventName" class="form-label">Event Name</label>
            <select name="event_id" id="eventName" class="form-select" required>
              <option value="{{ old('event_id', $schedule->event_id) }}" selected>{{ $schedule->event->name}}</option>
                @foreach ($events as $event)
                    @if ($event->id !== $schedule->event_id)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endif
                @endforeach
            </select>
            <div class="error-text" id="eventError"></div>
          </div>

          <!-- Team Home & Team Away -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="teamHome" class="form-label">Team Home</label>
              <select name="team_id_h" id="teamHome" class="form-select" required>
                <option value="{{ old('team_id_h', $schedule->team_id_h) }}" selected>{{ $schedule->teamH->name }}</option>
                  @foreach ($teams as $team)
                      @if ($team->id !== $schedule->team_id_h)
                          <option value="{{ $team->id }}">{{ $team->name }}</option>
                      @endif
                  @endforeach
              </select>
              @error('team_id_h')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="teamAway" class="form-label">Team Away</label>
              <select name="team_id_a" id="teamAway" class="form-select" required>
                <option value="{{ old('team_id_a', $schedule->team_id_a) }}" selected>{{ $schedule->teamA->name }}</option>
                  @foreach ($teams as $team)
                      @if ($team->id !== $schedule->team_id_a)
                          <option value="{{ $team->id }}">{{ $team->name }}</option>
                      @endif
                  @endforeach
              </select>
              @error('team_id_a')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Play Date -->
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="playDate" class="form-label">Play Date</label>
              <input type="datetime-local" class="form-control @error('play_date') is-invalid @enderror" id="playDate" name="play_date" value="{{ old('play_date', $schedule->play_date ? \Carbon\Carbon::parse($schedule->play_date)->format('Y-m-d\TH:i') : '') }}" required>
              @error('play_date')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Schedule</button>
            <a href="{{ route('schedule-list') }}" class="btn btn-secondary">Cancel</a>
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
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('eventName')) {
        new TomSelect('#eventName', { create: false });
    }
    if (document.getElementById('teamHome')) {
        new TomSelect('#teamHome', { create: false });
    }
    if (document.getElementById('teamAway')) {
        new TomSelect('#teamAway', { create: false });
    }
});
</script>
@endpush
