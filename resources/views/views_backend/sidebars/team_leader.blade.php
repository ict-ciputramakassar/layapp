<!-- TEAM LEADER SIDEBAR -->
<aside id="sidebar" class="sidebar overflow-y-auto overflow-x-hidden">
  <div class="logo-area">
    <a href="{{ route('team_leader.team_members') }}" class="d-inline-flex">
      <img src="{{ asset('images/backend/logo-icon.svg') }}" alt="" width="24">
      <span class="logo-text ms-2"><img src="{{ asset('images/backend/logo.svg') }}" alt=""></span>
    </a>
  </div>
  <ul class="nav flex-column">
    <li class="nav-text-space"><small class="nav-text text-muted">Main</small></li>
    <li><a class="nav-link @if(request()->routeIs('team_leader.team_members')) active @endif"
        href="{{ route('team_leader.team_members') }}"><i class="ti ti-home"></i><span class="nav-text">Team Members</span></a>
    </li>

    <li class="nav-text-space"><small class="nav-text text-muted">Team Management</small></li>
    <li><a class="nav-link @if(request()->routeIs('team_leader.add_team_member')) active @endif"
        href="{{ route('team_leader.add_team_member') }}"><i class="ti ti-plus"></i><span class="nav-text">Add Team Member</span></a>
    </li>

    {{-- <li class="nav-text-space"><small class="nav-text text-muted">Account</small></li>
    <li><a class="nav-link" href="{{ route('auth.login') }}"><i class="ti ti-logout"></i><span class="nav-text">Log
          in</span></a></li>
    <li><a class="nav-link" href="{{ route('auth.signup') }}"><i class="ti ti-user-plus"></i><span
          class="nav-text">Sign up</span></a></li> --}}

    <li class="nav-text-space"><small class="nav-text text-muted">Utilities</small></li>
    <li><a class="nav-link @if(request()->routeIs('error-404')) active @endif"
        href="{{ route('error-404') }}"><i class="ti ti-alert-circle"></i><span class="nav-text">404
          Error</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('docs')) active @endif" href="{{ route('docs') }}"><i
          class="ti ti-file-text"></i><span class="nav-text">Docs</span></a></li>
    <li><a class="nav-link @if(request()->routeIs('changelog')) active @endif"
        href="{{ route('changelog') }}"><i class="ti ti-exchange"></i><span
          class="nav-text">Changelog</span></a></li>
  </ul>
</aside>
