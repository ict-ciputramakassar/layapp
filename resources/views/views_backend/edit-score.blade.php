@extends('views_backend.layouts.app')

@section('title', 'Edit Schedule - LayApp')

@section('content')

<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Edit Score</h1>
        <p class="mb-0">Update score details</p>
      </div>
      <div>
        <a class="btn btn-primary" href="{{ route('score-list') }}">Go to Scores List</a>
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

        <form action="{{ route('score.update', $score->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Event Name -->
          <div class="mb-4">
            <label for="eventName" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="eventName" name="event_name" value="{{ old('event_name', $score->event?->name) }}" disabled>
            <div class="error-text" id="eventError"></div>
          </div>

          <!-- Team Home & Team Away -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="teamHome" class="form-label">Team Home</label>
              <input type="text" class="form-control" id="teamHome" name="team_id_h" value="{{ old('team_id_h', $score->teamH?->name) }}" disabled>
              @error('team_id_h')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="teamAway" class="form-label">Team Away</label>
              <input type="text" class="form-control" id="teamAway" name="team_id_a" value="{{ old('team_id_a', $score->teamA?->name) }}" disabled>
              @error('team_id_a')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Score Home & Score Away -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="scoreHome" class="form-label">Score Home</label>
              <input type="number" class="form-control" id="scoreHome" name="score_h" value="{{ old('score_h', $score->score_h) }}" min="0" required>
              @error('score_h')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="scoreAway" class="form-label">Score Away</label>
              <input type="number" class="form-control" id="scoreAway" name="score_a" value="{{ old('score_a', $score->score_a) }}" min="0" required>
              @error('score_a')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Play Date -->
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="playDate" class="form-label">Play Date</label>
              <input type="datetime-local" class="form-control @error('play_date') is-invalid @enderror" id="playDate" name="play_date" value="{{ old('play_date', $score->play_date ? \Carbon\Carbon::parse($score->play_date)->format('Y-m-d\TH:i') : '') }}" disabled>
              @error('play_date')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Score</button>
            <a href="{{ route('score-list') }}" class="btn btn-secondary">Cancel</a>
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
