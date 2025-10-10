<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebarMenu">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            {{-- @canSeeUsers()
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>
            @endcanSeeUsers --}}
            @can('view-users')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i> Users
                    </a>
                </li>
            @endcan


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                    href="{{ route('employees.index') }}">
                    <i class="bi bi-person-badge"></i> Employees
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('service-users.*') ? 'active' : '' }}"
                    href="{{ route('service-users.index') }}">
                    <i class="bi bi-person-heart"></i> Service Users
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('funders.*') ? 'active' : '' }}"
                    href="{{ route('funders.index') }}">
                    <i class="bi bi-building"></i> Funders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rostering.*') ? 'active' : '' }}"
                    href="{{ route('rostering.index') }}">
                    <i class="bi bi-calendar-week"></i> Rostering
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('timesheets.*') ? 'active' : '' }}"
                    href="{{ route('timesheets.index') }}">
                    <i class="bi bi-clock"></i> Timesheets
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}"
                    href="{{ route('invoices.index') }}">
                    <i class="bi bi-receipt"></i> Invoices
                </a>
            </li>

            @if (auth()->user()->role === 'super-admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                        href="{{ route('settings.index') }}">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
