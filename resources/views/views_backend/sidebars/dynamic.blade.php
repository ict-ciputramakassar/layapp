<!-- DYNAMIC SIDEBAR -->
@php
  // Retrieve the JSON permissions from the logged-in user's role
  // Make sure it defaults to an empty array instead of null
  $userPermissions = [];
  if (Auth::user() && Auth::user()->userType && Auth::user()->userType->permissions) {
      $decoded = json_decode(Auth::user()->userType->permissions, true);
      if (is_array($decoded)) {
          $userPermissions = $decoded;
      }
  }
@endphp

<aside id="sidebar" class="sidebar overflow-y-auto overflow-x-hidden">
  <div class="logo-area">
    <a href="{{ route('dashboard') }}" class="d-inline-flex">
      <img src="{{ asset('images/backend/logo-icon.svg') }}" alt="" width="24">
      <span class="logo-text ms-2"><img src="{{ asset('images/backend/logo.svg') }}" alt=""></span>
    </a>
  </div>
  <ul class="nav flex-column">

    @if(in_array('dashboard', $userPermissions) || in_array('reports', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Main</small></li>
    @endif

    @if(in_array('dashboard', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('dashboard') || request()->routeIs('dashboard') || request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a></li>
    @endif


    @if(in_array('reports', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('reports')) active @endif" href="{{ route('reports') }}"><i class="ti ti-receipt"></i><span class="nav-text">Reports</span></a></li>
    @endif

    @if(in_array('create_event', $userPermissions) || in_array('event_list', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Event</small></li>
    @endif

    @if(in_array('event_list', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('event-list')) active @endif" href="{{ route('event-list') }}"><i class="ti ti-list-check"></i><span class="nav-text">Event List</span></a></li>
    @endif

    @if(in_array('create_event', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('create-event')) active @endif" href="{{ route('create-event') }}"><i class="ti ti-calendar-plus"></i><span class="nav-text">Add Event</span></a></li>
    @endif

    @if(in_array('create_schedule', $userPermissions) || in_array('schedule_list', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Schedule</small></li>
    @endif

    @if(in_array('schedule_list', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('schedule-list') || request()->routeIs('superschedule.create')) active @endif" href="{{ route('schedule-list') }}"><i class="ti ti-clipboard-list"></i><span class="nav-text">Schedule List</span></a></li>
    @endif

    @if(in_array('create_schedule', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('create-schedule') || request()->routeIs('superschedule.create')) active @endif" href="{{ route('create-schedule') }}"><i class="ti ti-clock-plus"></i><span class="nav-text">Create Schedule</span></a></li>
    @endif

    @if(in_array('team_members', $userPermissions) || in_array('add_team_members', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Team</small></li>
    @endif

    @if(in_array('team_members', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('team_members')) active @endif" href="{{ route('team_members') }}"><i class="ti ti-users"></i><span class="nav-text">Team Members</span></a></li>
    @endif

    @if(in_array('add_team_members', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('add_team_member')) active @endif" href="{{ route('add_team_member') }}"><i class="ti ti-user-plus"></i><span class="nav-text">Add Team Member</span></a></li>
    @endif

    @if(in_array('score_list', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Score</small></li>
    @endif

    @if(in_array('score_list', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('score-list')) active @endif" href="{{ route('score-list') }}"><i class="ti ti-chart-bar"></i><span class="nav-text">Score List</span></a></li>
    @endif

    @if(in_array('user_roles', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Account</small></li>
    @endif

    @if(in_array('user_roles', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('user-roles')) active @endif" href="{{ route('user-roles') }}"><i class="ti ti-user-screen"></i><span class="nav-text">User Roles</span></a></li>
    @endif

    @if(in_array('docs', $userPermissions) || in_array('changelog', $userPermissions))
    <li class="nav-text-space"><small class="nav-text text-muted">Utilities</small></li>
    @endif

    @if(in_array('docs', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('docs')) active @endif" href="{{ route('docs') }}"><i class="ti ti-file-text"></i><span class="nav-text">Docs</span></a></li>
    @endif

    @if(in_array('changelog', $userPermissions))
    <li><a class="nav-link @if(request()->routeIs('changelog')) active @endif" href="{{ route('changelog') }}"><i class="ti ti-exchange"></i><span class="nav-text">Changelog</span></a></li>
    @endif
  </ul>
</aside>

