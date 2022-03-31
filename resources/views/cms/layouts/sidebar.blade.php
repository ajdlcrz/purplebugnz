<div id="mySidenav" class="sidebar">
    <ul class="p-0">
        @if (auth()->user()->role_id === 1)
        <li class="{{ (request()->is('cms/dashboard*')) ? 'active' : '' }}">
            <a class="sidebar-link text-center" href="{{ route('dashboard') }}" title="Dashboard">
                <span class="icon-dashboard"></span>
                <span class="sidebar-text d-none">Dashboard</span>
            </a>
        </li>

        <li class="{{ (request()->is('cms/activities*')) ? 'active' : '' }}" title="Activities">
            <a class="sidebar-link text-center" href="{{ route('activities') }}">
                <span class="icon-activities"></span>
                <span class="sidebar-text d-none">Activity Log</span>
            </a>
        </li>

        <li class="{{ (request()->is('cms/users*')) ? 'active' : '' }}" title="User Management">
            <a class="sidebar-link text-center" href="{{ route('users.index') }}">
                <span class="icon-users"></span>
                <span class="sidebar-text d-none">User Management</span>
            </a>
        </li>
        @endif

        <li class="{{ (request()->is('cms/pages*')) ? 'active' : '' }}" title="Page Management">
            <a class="sidebar-link text-center" href="{{ route('page.management') }}">
                <span class="icon-pages"></span>
                <span class="sidebar-text d-none">Page Management</span>
            </a>
        </li>
    </ul>
</div>
