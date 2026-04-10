@extends('views_backend.layouts.app')

@section('title', 'Changelog - InApp Inventory Dashboard')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
      <div>
        <h1 class="fs-3 mb-1">Changelog</h1>
        <p>Stay up to date with all of the latest additions and improvements we've made to Inapp Pro.</p>

        <!-- v1.1.0 Release -->
        <div class="row mt-12">
          <div class="col-lg-5 col-12">
            <div id="v1.1.0">
              <h4 class="mb-3 fw-semi-bold">
                <code>v1.1.0</code> - Feb 16, 2026
              </h4>
            </div>
          </div>
          <div class="col-md-7 col-12">
            <div>
              <h3 class="mb-4">Added HTML Page</h3>
              <ul class="list-unstyled fs-5">
                <li>User Roles <a class="link-primary fs-6" href="{{ route('admin.user-roles') }}">Demo <i class="ti ti-external-link"></i></a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- v1.0.0 Release -->
        <div class="row mt-7">
          <div class="col-lg-5 col-12">
            <div id="v1.0.0">
              <h4 class="mb-3 fw-semi-bold">
                <code>v1.0.0</code> - Jan 21, 2026
              </h4>
            </div>
          </div>
          <div class="col-md-7 col-12">
            <div>
              <h3 class="mb-0">Initial Release</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
